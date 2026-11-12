<?php
session_start();

// Бетті қорғау: жүйеге кірмеген пайдаланушы login.php бетіне жіберіледі
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$userId = $_SESSION["user_id"];
$message = "";

// Жаңа тапсырыстан бас тарту ($_POST) — тауар қоймаға қайтарылады
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cancel_id"])) {
    $orderId = (int) $_POST["cancel_id"];

    $stmt = $pdo->prepare(
        "SELECT size_id, quantity FROM orders WHERE id = ? AND user_id = ? AND status = 'new'"
    );
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch();

    if ($order) {
        $pdo->beginTransaction();
        $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?")
            ->execute([$orderId]);
        $pdo->prepare("UPDATE sizes SET stock = stock + ? WHERE id = ?")
            ->execute([$order["quantity"], $order["size_id"]]);
        $pdo->commit();

        $message = "Тапсырыстан бас тартылды.";
    }
}

// Пайдаланушы туралы мәлімет
$stmt = $pdo->prepare("SELECT full_name, email, phone, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Пайдаланушы дерекқордан өшірілген болса — сессияны жабу
if (!$user) {
    header("Location: logout.php");
    exit;
}

// Пайдаланушының тапсырыстары
$stmt = $pdo->prepare(
    "SELECT o.id, o.quantity, o.total_price, o.address, o.status, o.created_at,
            s.size_label, p.name AS product_name
     FROM orders o
     JOIN sizes s ON s.id = o.size_id
     JOIN products p ON p.id = s.product_id
     WHERE o.user_id = ?
     ORDER BY o.created_at DESC, o.id DESC"
);
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();

// Мәртебе атаулары
$statusNames = [
    "new"       => "Жаңа",
    "confirmed" => "Расталды",
    "shipped"   => "Жолда",
    "delivered" => "Жеткізілді",
    "cancelled" => "Бас тартылды"
];

$pageTitle = "Жеке кабинет | SizeFit";
include "header.php";
?>

<section class="profile-section">
    <div class="profile-card">
        <div class="avatar"><?= htmlspecialchars(mb_substr($user["full_name"], 0, 1)) ?></div>

        <h1>Қош келдіңіз, <?= htmlspecialchars($user["full_name"]) ?>!</h1>
        <p class="intro">Бұл — жүйеге кірген пайдаланушыға ғана көрінетін жеке кабинет.</p>

        <ul class="profile-info">
            <li><span>Email:</span> <?= htmlspecialchars($user["email"]) ?></li>
            <li><span>Телефон:</span> <?= htmlspecialchars($user["phone"]) ?></li>
            <li><span>Тіркелген күні:</span> <?= date("d.m.Y", strtotime($user["created_at"])) ?></li>
        </ul>

        <a href="logout.php" class="logout-btn">Жүйеден шығу</a>
    </div>

    <div class="bookings-card">
        <h2>Менің тапсырыстарым</h2>

        <?php if ($message !== ""): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (count($orders) === 0): ?>
            <p class="empty-message">
                Сізде әзірге тапсырыс жоқ.<br>
                <a href="catalog.php">Каталогқа өту →</a>
            </p>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Тауар</th>
                            <th>Өлшем</th>
                            <th>Саны</th>
                            <th>Сомасы</th>
                            <th>Күні</th>
                            <th>Мәртебе</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><?= htmlspecialchars($o["product_name"]) ?></td>
                                <td><b><?= htmlspecialchars($o["size_label"]) ?></b></td>
                                <td><?= (int) $o["quantity"] ?></td>
                                <td><?= number_format($o["total_price"], 0, ".", " ") ?> ₸</td>
                                <td><?= date("d.m.Y", strtotime($o["created_at"])) ?></td>
                                <td>
                                    <span class="badge <?= $o["status"] ?>">
                                        <?= $statusNames[$o["status"]] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($o["status"] === "new"): ?>
                                        <form method="POST" action="profile.php">
                                            <input type="hidden" name="cancel_id" value="<?= (int) $o["id"] ?>">
                                            <button type="submit" class="cancel-btn">Бас тарту</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include "footer.php"; ?>
