<?php
// Дерекқорға қосылу параметрлері (XAMPP үшін әдепкі мәндер)
$host = 'localhost';
$dbname = 'sizefit';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Қате болса, ерекшелік (exception) шығару
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Нәтижені ассоциативті массив түрінде алу
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Дерекқорға қосылу қатесі: " . $e->getMessage());
}
