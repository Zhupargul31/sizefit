<?php
include "data.php";

$message = "";
$messageType = "error";

// ---------- 1. Тапсырыс формасын серверде өңдеу ($_POST) ----------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = (int) ($_POST["product_id"] ?? 0);
    $size = $_POST["size"] ?? "";
    $quantity = (int) ($_POST["quantity"] ?? 0);
    $name = trim($_POST["client_name"] ?? "");
    $phone = trim($_POST["client_phone"] ?? "");
    $address = trim($_POST["address"] ?? "");

    // Таңдалған тауарды массивтен табу
    $selected = null;
    foreach ($products as $p) {
        if ($p["id"] === $productId) {
            $selected = $p;
        }
    }

    if ($name === "" || $phone === "" || $address === "" || $size === "") {
        $message = "Барлық өрісті толтырыңыз.";
    } elseif ($selected === null || !isset($selected["sizes"][$size])) {
        $message = "Тауар немесе өлшем табылмады.";
    } elseif (!preg_match('/^\+?7[0-9]{10}$/', $phone)) {
        $message = "Телефон нөмірін +77001234567 форматында енгізіңіз.";
    } elseif ($quantity < 1 || $quantity > 5) {
        $message = "Саны 1-ден 5-ке дейін болуы керек.";
    } elseif ($selected["sizes"][$size] === 0) {
        $message = "Кешіріңіз, " . $size . " өлшемі таусылды.";
    } elseif ($selected["sizes"][$size] < $quantity) {
        $message = "Кешіріңіз, " . $size . " өлшемінде тек "
                 . $selected["sizes"][$size] . " дана қалды.";
    } else {
        $total = $selected["price"] * $quantity;

        $messageType = "success";
        $message = "Құрметті " . $name . ", «" . $selected["name"] . "» (" . $size . ", "
                 . $quantity . " дана) тапсырысыңыз қабылданды! Жалпы сомасы: "
                 . number_format($total, 0, ".", " ") . " ₸. Жақын арада "
                 . $phone . " нөмірі арқылы хабарласамыз.";
    }
}

// ---------- 2. Іздеу және сүзгілеу ($_GET) ----------
$search = trim($_GET["search"] ?? "");
$category = $_GET["category"] ?? "";
$size = $_GET["size"] ?? "";

$allSizes = ["XS", "S", "M", "L", "XL", "XXL"];
$categories = array_unique(array_column($products, "category"));
sort($categories);

$filtered = [];

foreach ($products as $product) {
    $matchesText = $search === "" || mb_stripos($product["name"], $search, 0, "UTF-8") !== false;
    $matchesCategory = $category === "" || $product["category"] === $category;
    $matchesSize = $size === "" || (($product["sizes"][$size] ?? 0) > 0);

    if ($matchesText && $matchesCategory && $matchesSize) {
        $filtered[] = $product;
    }
}

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
        </div>
    <?php endif; ?>

    <p class="result-count">Табылған тауарлар: <b><?= count($filtered) ?></b></p>

    <div class="products-grid">
        <?php foreach ($filtered as $product):
            $available = array_filter($product["sizes"], fn($stock) => $stock > 0);
        ?>
            <article class="product-card">
                <div class="product-top" style="background: <?= htmlspecialchars($product["color"]) ?>;">
                    <span class="gender-tag"><?= htmlspecialchars($product["gender"]) ?></span>
                    <span class="product-icon"><?= $product["icon"] ?></span>
                    <span class="product-type"><?= htmlspecialchars($product["category"]) ?></span>
                </div>

                <div class="product-info">
                    <h3><?= htmlspecialchars($product["name"]) ?></h3>
                    <p class="product-desc"><?= htmlspecialchars($product["description"]) ?></p>

                    <div class="sizes-row">
                        <?php foreach ($product["sizes"] as $label => $stock): ?>
                            <span class="size-chip <?= $stock > 0 ? "" : "out" ?>"
                                  title="Қоймада: <?= $stock ?> дана"><?= $label ?></span>
                        <?php endforeach; ?>
                    </div>

                    <p class="price"><?= number_format($product["price"], 0, ".", " ") ?> ₸</p>

                    <?php if (count($available) === 0): ?>
                        <button class="order-btn" disabled>Барлық өлшем таусылды</button>
                    <?php else: ?>
                        <form method="POST" action="catalog.php" class="order-form">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">

                            <div class="date-row">
                                <label>
                                    Өлшем
                                    <select name="size" required>
                                        <?php foreach ($available as $label => $stock): ?>
                                            <option value="<?= $label ?>" <?= $label === $size ? "selected" : "" ?>>
                                                <?= $label ?> (<?= $stock ?> дана)
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
                                Аты-жөніңіз
                                <input type="text" name="client_name" placeholder="Атыңыз" required>
                            </label>

                            <label class="field">
                                Телефон
                                <input type="text" name="client_phone" placeholder="+77001234567" required>
                            </label>

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

    <?php if (count($filtered) === 0): ?>
        <p class="empty-message">
            Іздеу бойынша тауар табылмады.<br>
            <a href="catalog.php">Барлық тауарды көру →</a>
        </p>
    <?php endif; ?>
</section>

<?php include "footer.php"; ?>
