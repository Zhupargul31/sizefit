<?php
$message = "";
$success = false;

// Кіру формасын серверде тексеру ($_POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email мекенжайын дұрыс енгізіңіз.";
    } elseif ($password === "") {
        $message = "Құпиясөзді енгізіңіз.";
    } else {
        // 11-аптада: users кестесінен email бойынша іздеп,
        // password_verify() арқылы тексеріп, сессия ашамыз.
        $success = true;
        $message = "Форма дұрыс толтырылды. Аккаунтты тексеру 11-аптада дерекқор арқылы қосылады.";
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
        <div class="message <?= $success ? "success" : "error" ?>">
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
