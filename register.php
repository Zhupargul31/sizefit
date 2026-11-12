<?php
session_start();
require_once "db.php";

// Жүйеге кіріп тұрған пайдаланушыны кабинетке жіберу
if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit;
}

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($name === "" || $email === "" ||
        $phone === "" || $password === "" || $confirm === "") {
        $message = "Барлық өрісті толтырыңыз.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email мекенжайын дұрыс енгізіңіз.";
    } elseif (!preg_match('/^\+?7[0-9]{10}$/', $phone)) {
        $message = "Телефон нөмірін +77001234567 форматында енгізіңіз.";
    } elseif (strlen($password) < 8) {
        $message = "Құпиясөз кемінде 8 таңба болуы керек.";
    } elseif ($password !== $confirm) {
        $message = "Құпиясөздер сәйкес келмейді.";
    } else {
        // Бұл email бұрын тіркелген бе?
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $message = "Бұл email бұрын тіркелген.";
        } else {
            // Құпиясөзді хэштеу — ашық түрде сақталмайды
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $insert = $pdo->prepare(
                "INSERT INTO users (full_name, email, phone, password_hash)
                 VALUES (?, ?, ?, ?)"
            );
            $insert->execute([$name, $email, $phone, $passwordHash]);

            $success = true;
            $message = "Тіркелу сәтті өтті! Енді жүйеге кіре аласыз.";
            $_POST = []; // форманы тазалау
        }
    }
}

// Форма қате болса, енгізілген мәндер өшіп қалмауы үшін
function old($field) {
    return htmlspecialchars($_POST[$field] ?? "", ENT_QUOTES, "UTF-8");
}

$pageTitle = "Тіркелу | SizeFit";
include "header.php";
?>

<div class="form-container">
    <h1>Тіркелу</h1>

    <p class="intro">
        SizeFit жүйесіне тіркеліп, өз өлшеміңізге
        сай киімге онлайн тапсырыс беріңіз.
    </p>

    <?php if ($message !== ""): ?>
        <div class="message <?= $success ? "success" : "error" ?>">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            <?php if ($success): ?>
                <a href="login.php">Кіру →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php" id="registerForm">
        <label for="name">Аты-жөніңіз</label>
        <input type="text" id="name" name="name"
               placeholder="Атыңыз бен тегіңіз"
               value="<?= old("name") ?>" required minlength="2">

        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               placeholder="name@example.com"
               value="<?= old("email") ?>" required>

        <label for="phone">Телефон</label>
        <input type="tel" id="phone" name="phone"
               placeholder="+77001234567"
               value="<?= old("phone") ?>" required>

        <label for="password">Құпиясөз</label>
        <input type="password" id="password" name="password"
               placeholder="Кемінде 8 таңба" minlength="8" required>

        <label for="confirm_password">Құпиясөзді қайталаңыз</label>
        <input type="password" id="confirm_password" name="confirm_password"
               placeholder="Құпиясөзді қайталаңыз" minlength="8" required>

        <p class="form-error" hidden></p>
        <button type="submit">Тіркелу</button>
    </form>

    <p class="bottom">
        Аккаунтыңыз бар ма?
        <a href="login.php">Жүйеге кіру</a>
    </p>
</div>

<?php include "footer.php"; ?>
