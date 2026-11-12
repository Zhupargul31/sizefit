<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог | SizeFit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Size<span>Fit</span></a>

    <button class="burger" id="burger" aria-label="Мәзірді ашу">☰</button>

    <nav id="nav">
        <a href="index.php">Басты бет</a>
        <a href="catalog.php" class="active">Каталог</a>
        <a href="size.php">Өлшемді анықтау</a>
    </nav>
</header>

<main>
<section class="page-title">
    <p class="subtitle">КИІМДЕР КАТАЛОГЫ</p>
    <h1>Өзіңе ұнайтын киімді таңда</h1>
    <p>Өлшеміңді білмесең — <a href="size.php" style="text-decoration: underline;">өлшем кеңесшісін</a> қолдан.</p>
</section>

<section class="search-section">
    <!-- Іздеу JavaScript арқылы бетте бірден жұмыс істейді (script.js) -->
    <div class="search-box">
        <input type="text" id="liveSearch" placeholder="Киім атауы (мыс.: футболка, джинсы)...">

        <select id="categoryFilter">
            <option value="">Барлық санат</option>
            <option value="Жейде">Жейде</option>
            <option value="Көйлек">Көйлек</option>
            <option value="Свитер">Свитер</option>
            <option value="Сыртқы киім">Сыртқы киім</option>
            <option value="Футболка">Футболка</option>
            <option value="Худи">Худи</option>
            <option value="Шалбар">Шалбар</option>
        </select>

        <select id="sizeFilter">
            <option value="">Барлық өлшем</option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
        </select>
    </div>
</section>

<section class="products-section">
    <div class="products-grid">
        <article class="product-card" data-name="Классикалық ақ футболка" data-category="Футболка" data-sizes="XS,S,M,L,XL,XXL">
            <div class="product-top" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0);">
                <span class="gender-tag">Унисекс</span>
                <span class="product-icon">👕</span>
                <span class="product-type">Футболка</span>
            </div>

            <div class="product-info">
                <h3>Классикалық ақ футболка</h3>
                <p class="product-desc">100% мақта, тығыз тоқылған, күнделікті киюге ыңғайлы</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip">XXL</span>
                </div>

                <p class="price">6 500 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Классикалық ақ футболка">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Slim Fit джинсы" data-category="Шалбар" data-sizes="XS,S,M,L">
            <div class="product-top" style="background: linear-gradient(135deg, #dbeafe, #93c5fd);">
                <span class="gender-tag">Әйелдер</span>
                <span class="product-icon">👖</span>
                <span class="product-type">Шалбар</span>
            </div>

            <div class="product-info">
                <h3>Slim Fit джинсы</h3>
                <p class="product-desc">Созылмалы деним, жіңішке пішін, жоғары бел</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip out">XL</span>
                    <span class="size-chip out">XXL</span>
                </div>

                <p class="price">18 900 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Slim Fit джинсы">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Жүн свитер" data-category="Свитер" data-sizes="S,M,L,XL,XXL">
            <div class="product-top" style="background: linear-gradient(135deg, #fef3c7, #fcd34d);">
                <span class="gender-tag">Унисекс</span>
                <span class="product-icon">🧶</span>
                <span class="product-type">Свитер</span>
            </div>

            <div class="product-info">
                <h3>Жүн свитер</h3>
                <p class="product-desc">Жұмсақ жүн аралас мата, суық күндерге арналған</p>

                <div class="sizes-row">
                    <span class="size-chip out">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip">XXL</span>
                </div>

                <p class="price">15 900 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Жүн свитер">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Классикалық жейде" data-category="Жейде" data-sizes="S,M,L,XL,XXL">
            <div class="product-top" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd);">
                <span class="gender-tag">Ерлер</span>
                <span class="product-icon">👔</span>
                <span class="product-type">Жейде</span>
            </div>

            <div class="product-info">
                <h3>Классикалық жейде</h3>
                <p class="product-desc">Кеңсеге және ресми кездесулерге лайық</p>

                <div class="sizes-row">
                    <span class="size-chip out">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip">XXL</span>
                </div>

                <p class="price">12 500 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Классикалық жейде">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Спорттық худи" data-category="Худи" data-sizes="XS,S,M,L,XL">
            <div class="product-top" style="background: linear-gradient(135deg, #f3e8ff, #d8b4fe);">
                <span class="gender-tag">Унисекс</span>
                <span class="product-icon">🧥</span>
                <span class="product-type">Худи</span>
            </div>

            <div class="product-info">
                <h3>Спорттық худи</h3>
                <p class="product-desc">Ішкі жағы жылы, күләпарасы және қалтасы бар</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip out">XXL</span>
                </div>

                <p class="price">17 500 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Спорттық худи">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Күзгі пальто" data-category="Сыртқы киім" data-sizes="XS,S,M">
            <div class="product-top" style="background: linear-gradient(135deg, #fde68a, #d6a75c);">
                <span class="gender-tag">Әйелдер</span>
                <span class="product-icon">🧥</span>
                <span class="product-type">Сыртқы киім</span>
            </div>

            <div class="product-info">
                <h3>Күзгі пальто</h3>
                <p class="product-desc">Ұзын классикалық пальто, белбеуі бар</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip out">L</span>
                    <span class="size-chip out">XL</span>
                    <span class="size-chip out">XXL</span>
                </div>

                <p class="price">45 000 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Күзгі пальто">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Жазғы көйлек" data-category="Көйлек" data-sizes="XS,S,M,L,XL">
            <div class="product-top" style="background: linear-gradient(135deg, #fce7f3, #f9a8d4);">
                <span class="gender-tag">Әйелдер</span>
                <span class="product-icon">👗</span>
                <span class="product-type">Көйлек</span>
            </div>

            <div class="product-info">
                <h3>Жазғы көйлек</h3>
                <p class="product-desc">Жеңіл шифон мата, гүлді өрнекпен</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip out">XXL</span>
                </div>

                <p class="price">22 000 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Жазғы көйлек">Тапсырыс беру</button>
            </div>
        </article>
        <article class="product-card" data-name="Спорттық шалбар" data-category="Шалбар" data-sizes="XS,S,M,L,XL,XXL">
            <div class="product-top" style="background: linear-gradient(135deg, #dcfce7, #86efac);">
                <span class="gender-tag">Унисекс</span>
                <span class="product-icon">🩳</span>
                <span class="product-type">Шалбар</span>
            </div>

            <div class="product-info">
                <h3>Спорттық шалбар</h3>
                <p class="product-desc">Жаттығуға және серуенге ыңғайлы, белі резеңке</p>

                <div class="sizes-row">
                    <span class="size-chip">XS</span>
                    <span class="size-chip">S</span>
                    <span class="size-chip">M</span>
                    <span class="size-chip">L</span>
                    <span class="size-chip">XL</span>
                    <span class="size-chip">XXL</span>
                </div>

                <p class="price">11 900 ₸</p>
                <button type="button" class="order-btn js-order" data-name="Спорттық шалбар">Тапсырыс беру</button>
            </div>
        </article>
    </div>

    <p id="emptyMessage" class="empty-message" hidden>Іздеу бойынша тауар табылмады.</p>
</section>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Size<span>Fit</span></a>
    <p>© 2026 SizeFit. Онлайн киім өлшемін таңдау және тапсырыс беру жүйесі. Оқу жобасы.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
