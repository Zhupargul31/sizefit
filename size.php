<?php
include "size_chart.php";

$message = "";
$recommended = null;
$tallNote = false;

// Өлшем анықтау формасын серверде өңдеу ($_POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $chest = (float) str_replace(",", ".", $_POST["chest"] ?? "");
    $waist = (float) str_replace(",", ".", $_POST["waist"] ?? "");
    $height = (float) str_replace(",", ".", $_POST["height"] ?? "");

    if ($chest <= 0 || $waist <= 0 || $height <= 0) {
        $message = "Барлық өлшемді сантиметрмен енгізіңіз.";
    } elseif ($height < 140 || $height > 210) {
        $message = "Бойыңызды 140–210 см аралығында енгізіңіз.";
    } else {
        $recommended = recommendSize($chest, $waist, $sizeChart);

        if ($recommended === null) {
            $message = "Бұл өлшемдер кестеден тыс (кеуде 80–116 см, бел 62–98 см). "
                     . "Кеңесшімізге хабарласыңыз.";
        }

        // Бойы ұзын болса, ескерту беру
        $tallNote = $height >= 180;
    }
}

$pageTitle = "Өлшемді анықтау | SizeFit";
include "header.php";
?>

<section class="page-title">
    <p class="subtitle">ӨЛШЕМ КЕҢЕСШІСІ</p>
    <h1>Өлшеміңді анықта</h1>
    <p>Сантиметрлік таспамен өлшеп, мәндерді енгізіңіз.</p>
</section>

<section class="size-page">
    <div class="size-card">
        <h2>Өлшемдеріңіз</h2>
        <p class="intro">Кеудені — ең кең жерінен, белді — ең жіңішке жерінен өлшеңіз.</p>

        <?php if ($message !== ""): ?>
            <div class="message error"><?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></div>
        <?php endif; ?>

        <form method="POST" action="size.php" id="sizeForm">
            <label for="chest">Кеуде айналымы (см)</label>
            <input type="number" id="chest" name="chest" min="60" max="140" step="0.5"
                   placeholder="Мысалы: 92"
                   value="<?= htmlspecialchars($_POST["chest"] ?? "", ENT_QUOTES, "UTF-8") ?>" required>

            <label for="waist">Бел айналымы (см)</label>
            <input type="number" id="waist" name="waist" min="50" max="130" step="0.5"
                   placeholder="Мысалы: 74"
                   value="<?= htmlspecialchars($_POST["waist"] ?? "", ENT_QUOTES, "UTF-8") ?>" required>

            <label for="height">Бойы (см)</label>
            <input type="number" id="height" name="height" min="140" max="210"
                   placeholder="Мысалы: 165"
                   value="<?= htmlspecialchars($_POST["height"] ?? "", ENT_QUOTES, "UTF-8") ?>" required>

            <button type="submit">Өлшемді анықтау</button>
        </form>

        <?php if ($recommended !== null): ?>
            <div class="size-result">
                <p>Сізге ұсынылатын өлшем:</p>
                <div class="big-size"><?= $recommended ?></div>
                <?php if ($tallNote): ?>
                    <p>Бойыңыз ұзын — ұзартылған (Tall) үлгілерді таңдаған дұрыс.</p>
                <?php endif; ?>
                <a href="catalog.php?size=<?= $recommended ?>" class="main-btn">
                    <?= $recommended ?> өлшеміндегі киімдер →
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="size-card">
        <h2>Өлшемдер кестесі</h2>
        <p class="intro">Барлық мән сантиметрмен берілген.</p>

        <div class="table-wrapper">
            <table class="size-table">
                <thead>
                    <tr>
                        <th>Өлшем</th>
                        <th>Кеуде</th>
                        <th>Бел</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sizeChart as $row): ?>
                        <tr class="<?= $row["size"] === $recommended ? "highlight" : "" ?>">
                            <td><?= $row["size"] ?></td>
                            <td><?= $row["chest_from"] ?>–<?= $row["chest_to"] ?></td>
                            <td><?= $row["waist_from"] ?>–<?= $row["waist_to"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
