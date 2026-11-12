<?php
// Әр беттің жоғарғы бөлігі: <head>, логотип және мәзір.
// Қолдану: $pageTitle = "..."; include "header.php";
$pageTitle = $pageTitle ?? "SizeFit — Онлайн киім өлшемін таңдау және тапсырыс беру";
$currentPage = basename($_SERVER["PHP_SELF"]);

// Ағымдағы бетті мәзірде белгілеу
function activeClass($page, $currentPage) {
    return $page === $currentPage ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Size<span>Fit</span></a>

    <button class="burger" id="burger" aria-label="Мәзірді ашу">☰</button>

    <nav id="nav">
        <a href="index.php"<?= activeClass("index.php", $currentPage) ?>>Басты бет</a>
        <a href="catalog.php"<?= activeClass("catalog.php", $currentPage) ?>>Каталог</a>
        <a href="size.php"<?= activeClass("size.php", $currentPage) ?>>Өлшемді анықтау</a>
        <a href="login.php"<?= activeClass("login.php", $currentPage) ?>>Кіру</a>
        <a href="register.php" class="main-btn small">Тіркелу</a>
    </nav>
</header>

<main>
