<?php
session_start();
require_once "db.php";

// Жүйеге кіріп тұрған пайдаланушыны кабинетке жіберу
if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit;
}

$message = "";

// Каталог бетінен жіберілсе, ескерту көрсету
if (isset($_GET["need_login"])) {
    $message = "Тапсырыс беру үшін алдымен жүйеге кіріңіз.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email мекенжайын дұрыс енгізіңіз.";
    } elseif ($password === "") {
        $message = "Құпиясөзді енгізіңіз.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Хэштелген құпиясөзбен салыстыру
        if ($user && password_verify($password, $user["password_hash"])) {
            // Сессияны ұрлаудан қорғау үшін жаңа ID беру
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["full_name"];
            $_SESSION["user_role"] = $user["role"];

            header("Location: profile.php");
            exit;
        } else {
            $message = "Email немесе құпиясөз қате.";
        }
    }
}

$pageTitle = "Жүйеге кіру | SizeFit";
include "header.php";
?>

<div class="form-container">
    <h1>Жүйеге кіру</h1>

    <p class="intro">
        Тапсырыс беру үшін email мен құпиясөзіңізді енгізіңіз.
    </p>

    <?php if ($message !== ""): ?>
        <div class="message error">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="name@example.com"
            value="<?= htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            required
        >

        <label for="password">Құпиясөз</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Құпиясөзіңіз"
            required
        >

        <button type="submit">Кіру</button>
    </form>

    <p class="bottom">
        Аккаунтыңыз жоқ па?
        <a href="register.php">Тіркелу</a>
    </p>
</div>

<?php include "footer.php"; ?>
