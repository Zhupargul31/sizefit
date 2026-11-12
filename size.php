<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Өлшемді анықтау | SizeFit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Size<span>Fit</span></a>

    <button class="burger" id="burger" aria-label="Мәзірді ашу">☰</button>

    <nav id="nav">
        <a href="index.php">Басты бет</a>
        <a href="catalog.php">Каталог</a>
        <a href="size.php" class="active">Өлшемді анықтау</a>
    </nav>
</header>

<main>
<section class="page-title">
    <p class="subtitle">ӨЛШЕМ КЕҢЕСШІСІ</p>
    <h1>Өлшеміңді анықта</h1>
    <p>Сантиметрлік таспамен өлшеп, мәндерді енгізіңіз.</p>
</section>

<section class="size-page">
    <div class="size-card">
        <h2>Өлшемдеріңіз</h2>
        <p class="intro">Кеудені — ең кең жерінен, белді — ең жіңішке жерінен өлшеңіз.</p>

        <!-- Әзірге өлшем JavaScript арқылы есептеледі (script.js) -->
        <form id="jsSizeForm">
            <label for="chest">Кеуде айналымы (см)</label>
            <input type="number" id="chest" min="60" max="140" step="0.5" placeholder="Мысалы: 92" required>

            <label for="waist">Бел айналымы (см)</label>
            <input type="number" id="waist" min="50" max="130" step="0.5" placeholder="Мысалы: 74" required>

            <label for="height">Бойы (см)</label>
            <input type="number" id="height" min="140" max="210" placeholder="Мысалы: 165" required>

            <p class="form-error" hidden></p>
            <button type="submit">Өлшемді анықтау</button>
        </form>

        <div class="size-result" id="sizeResult" hidden>
            <p>Сізге ұсынылатын өлшем:</p>
            <div class="big-size" id="bigSize"></div>
            <a href="catalog.php" class="main-btn">Каталогқа өту →</a>
        </div>
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
                    <tr data-size="XS">
                        <td>XS</td>
                        <td>80–85</td>
                        <td>62–67</td>
                    </tr>
                    <tr data-size="S">
                        <td>S</td>
                        <td>86–91</td>
                        <td>68–73</td>
                    </tr>
                    <tr data-size="M">
                        <td>M</td>
                        <td>92–97</td>
                        <td>74–79</td>
                    </tr>
                    <tr data-size="L">
                        <td>L</td>
                        <td>98–103</td>
                        <td>80–85</td>
                    </tr>
                    <tr data-size="XL">
                        <td>XL</td>
                        <td>104–109</td>
                        <td>86–91</td>
                    </tr>
                    <tr data-size="XXL">
                        <td>XXL</td>
                        <td>110–116</td>
                        <td>92–98</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Size<span>Fit</span></a>
    <p>© 2026 SizeFit. Онлайн киім өлшемін таңдау және тапсырыс беру жүйесі. Оқу жобасы.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
