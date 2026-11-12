<?php
session_start();
require_once "db.php";

$message = "";
$messageType = "error";

// ---------- 1. Тапсырыс формасын өңдеу ($_POST) ----------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Тапсырысты тек жүйеге кірген пайдаланушы бере алады
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php?need_login=1");
        exit;
    }

    $sizeId = (int) ($_POST["size_id"] ?? 0);
    $quantity = (int) ($_POST["quantity"] ?? 0);
    $address = trim($_POST["address"] ?? "");

    if ($sizeId <= 0 || $address === "") {
        $message = "Өлшемді таңдап, жеткізу мекенжайын жазыңыз.";
    } elseif ($quantity < 1 || $quantity > 5) {
        $message = "Саны 1-ден 5-ке дейін болуы керек.";
    } elseif (mb_strlen($address) < 5) {
        $message = "Жеткізу мекенжайын толығырақ жазыңыз.";
    } else {
        // Таңдалған өлшем мен тауарды табу
        $stmt = $pdo->prepare(
            "SELECT s.id, s.size_label, s.stock, p.name, p.price
             FROM sizes s
             JOIN products p ON p.id = s.product_id
             WHERE s.id = ?"
        );
        $stmt->execute([$sizeId]);
        $item = $stmt->fetch();

        if (!$item) {
            $message = "Тауар табылмады.";
        } elseif ($item["stock"] <= 0) {
            $message = "Кешіріңіз, " . $item["size_label"] . " өлшемі таусылды.";
        } elseif ($item["stock"] < $quantity) {
            $message = "Кешіріңіз, " . $item["size_label"] . " өлшемінде тек "
                     . $item["stock"] . " дана қалды.";
        } else {
            // Қойманы азайту және тапсырысты сақтау — бірге (транзакция)
            $pdo->beginTransaction();

            $update = $pdo->prepare(
                "UPDATE sizes SET stock = stock - ? WHERE id = ? AND stock >= ?"
            );
            $update->execute([$quantity, $sizeId, $quantity]);

            if ($update->rowCount() === 1) {
                $total = $item["price"] * $quantity;

                $insert = $pdo->prepare(
                    "INSERT INTO orders (user_id, size_id, quantity, total_price, address)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $insert->execute([$_SESSION["user_id"], $sizeId, $quantity, $total, $address]);
                $pdo->commit();

                $messageType = "success";
                $message = "«" . $item["name"] . "» (" . $item["size_label"] . ", " . $quantity
                         . " дана) тапсырысыңыз қабылданды! Жалпы сомасы: "
                         . number_format($total, 0, ".", " ") . " ₸.";
            } else {
                $pdo->rollBack();
                $message = "Бұл өлшем жаңа ғана таусылды. Басқа өлшем таңдаңыз.";
            }
        }
    }
}

// ---------- 2. Іздеу және сүзгілеу ($_GET) ----------
$search = trim($_GET["search"] ?? "");
$category = $_GET["category"] ?? "";
$size = $_GET["size"] ?? "";

$allSizes = ["XS", "S", "M", "L", "XL", "XXL"];

// Санаттар тізімін дерекқордан алу
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")
                  ->fetchAll(PDO::FETCH_COLUMN);

$sql = "SELECT * FROM products p WHERE 1 = 1";
$params = [];

if ($search !== "") {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%" . $search . "%";
}

if (in_array($category, $categories, true)) {
    $sql .= " AND p.category = ?";
    $params[] = $category;
}

// Таңдалған өлшем қоймада бар тауарлар ғана
if (in_array($size, $allSizes, true)) {
    $sql .= " AND EXISTS (SELECT 1 FROM sizes s
                          WHERE s.product_id = p.id AND s.size_label = ? AND s.stock > 0)";
    $params[] = $size;
}

$sql .= " ORDER BY p.id";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Әр тауардың өлшемдерін алу
$sizeStmt = $pdo->prepare(
    "SELECT id, size_label, stock FROM sizes WHERE product_id = ?
     ORDER BY CASE size_label
                  WHEN 'XS' THEN 1 WHEN 'S' THEN 2 WHEN 'M' THEN 3
                  WHEN 'L' THEN 4 WHEN 'XL' THEN 5 ELSE 6
              END"
);

foreach ($products as $i => $product) {
    $sizeStmt->execute([$product["id"]]);
    $products[$i]["sizes"] = $sizeStmt->fetchAll();
}

$isLoggedIn = isset($_SESSION["user_id"]);

$pageTitle = "Каталог | SizeFit";
include "header.php";
?>

<section class="page-title">
    <p class="subtitle">КИІМДЕР КАТАЛОГЫ</p>
    <h1>Өзіңе ұнайтын киімді таңда</h1>
    <p>Өлшеміңді білмесең — <a href="size.php" style="text-decoration: underline;">өлшем кеңесшісін</a> қолдан.</p>
</section>

<section class="search-section">
    <form method="GET" action="catalog.php" class="search-box">
        <input type="text" name="search" placeholder="Киім атауы (мыс.: футболка, джинсы)..."
               value="<?= htmlspecialchars($search, ENT_QUOTES, "UTF-8") ?>">

        <select name="category">
            <option value="">Барлық санат</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>" <?= $category === $c ? "selected" : "" ?>>
                    <?= htmlspecialchars($c) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="size">
            <option value="">Барлық өлшем</option>
            <?php foreach ($allSizes as $s): ?>
                <option value="<?= $s ?>" <?= $size === $s ? "selected" : "" ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Іздеу</button>

        <?php if ($search !== "" || $category !== "" || $size !== ""): ?>
            <a href="catalog.php" class="reset-link">Тазалау</a>
        <?php endif; ?>
    </form>
</section>

<section class="products-section">

    <?php if ($message !== ""): ?>
        <div class="message <?= $messageType ?>">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            <?php if ($messageType === "success"): ?>
                <a href="profile.php">Тапсырыстарым →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <p class="result-count">Табылған тауарлар: <b><?= count($products) ?></b></p>

    <div class="products-grid">
        <?php foreach ($products as $product):
            $available = array_filter($product["sizes"], fn($s) => $s["stock"] > 0);
        ?>
            <article class="product-card">
                <div class="product-top" style="background: <?= htmlspecialchars($product["color"]) ?>;">
                    <span class="gender-tag"><?= htmlspecialchars($product["gender"]) ?></span>
                    <span class="product-icon"><?= htmlspecialchars($product["icon"]) ?></span>
                    <span class="product-type"><?= htmlspecialchars($product["category"]) ?></span>
                </div>

                <div class="product-info">
                    <h3><?= htmlspecialchars($product["name"]) ?></h3>
                    <p class="product-desc"><?= htmlspecialchars($product["description"]) ?></p>

                    <div class="sizes-row">
                        <?php foreach ($product["sizes"] as $s): ?>
                            <span class="size-chip <?= $s["stock"] > 0 ? "" : "out" ?>"
                                  title="Қоймада: <?= (int) $s["stock"] ?> дана">
                                <?= htmlspecialchars($s["size_label"]) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <p class="price"><?= number_format($product["price"], 0, ".", " ") ?> ₸</p>

                    <?php if (count($available) === 0): ?>
                        <button class="order-btn" disabled>Барлық өлшем таусылды</button>

                    <?php elseif (!$isLoggedIn): ?>
                        <a href="login.php?need_login=1" class="order-btn">Тапсырыс беру үшін кіріңіз</a>

                    <?php else: ?>
                        <form method="POST" action="catalog.php" class="order-form">
                            <div class="date-row">
                                <label>
                                    Өлшем
                                    <select name="size_id" required>
                                        <?php foreach ($available as $s): ?>
                                            <option value="<?= (int) $s["id"] ?>"
                                                <?= $s["size_label"] === $size ? "selected" : "" ?>>
                                                <?= htmlspecialchars($s["size_label"]) ?> (<?= (int) $s["stock"] ?> дана)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <label>
                                    Саны
                                    <input type="number" name="quantity" value="1" min="1" max="5" required>
                                </label>
                            </div>

                            <label class="field">
                                Жеткізу мекенжайы
                                <input type="text" name="address" placeholder="Қала, көше, үй" required>
                            </label>

                            <p class="form-error" hidden></p>
                            <button type="submit" class="order-btn">Тапсырыс беру</button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if (count($products) === 0): ?>
        <p class="empty-message">
            Іздеу бойынша тауар табылмады.<br>
            <a href="catalog.php">Барлық тауарды көру →</a>
        </p>
    <?php endif; ?>
</section>

<?php include "footer.php"; ?>
