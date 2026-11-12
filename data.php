<?php
// Тауарлар тізімі. Әзірге массивте сақталады.
// 11-аптада бұл деректер MySQL-дегі products және sizes кестелерінен алынады.
// Бұл файл catalog.php бетіне include арқылы қосылады.

$products = [
    ["id" => 1, "name" => "Классикалық ақ футболка", "category" => "Футболка", "gender" => "Унисекс", "price" => 6500,
     "color" => "linear-gradient(135deg, #f8fafc, #e2e8f0)", "icon" => "👕",
     "description" => "100% мақта, тығыз тоқылған, күнделікті киюге ыңғайлы",
     "sizes" => ["XS" => 3, "S" => 8, "M" => 10, "L" => 7, "XL" => 4, "XXL" => 2]],
    ["id" => 2, "name" => "Slim Fit джинсы", "category" => "Шалбар", "gender" => "Әйелдер", "price" => 18900,
     "color" => "linear-gradient(135deg, #dbeafe, #93c5fd)", "icon" => "👖",
     "description" => "Созылмалы деним, жіңішке пішін, жоғары бел",
     "sizes" => ["XS" => 2, "S" => 5, "M" => 6, "L" => 4, "XL" => 0, "XXL" => 0]],
    ["id" => 3, "name" => "Жүн свитер", "category" => "Свитер", "gender" => "Унисекс", "price" => 15900,
     "color" => "linear-gradient(135deg, #fef3c7, #fcd34d)", "icon" => "🧶",
     "description" => "Жұмсақ жүн аралас мата, суық күндерге арналған",
     "sizes" => ["XS" => 0, "S" => 4, "M" => 6, "L" => 5, "XL" => 3, "XXL" => 1]],
    ["id" => 4, "name" => "Классикалық жейде", "category" => "Жейде", "gender" => "Ерлер", "price" => 12500,
     "color" => "linear-gradient(135deg, #e0f2fe, #bae6fd)", "icon" => "👔",
     "description" => "Кеңсеге және ресми кездесулерге лайық",
     "sizes" => ["XS" => 0, "S" => 3, "M" => 5, "L" => 6, "XL" => 4, "XXL" => 2]],
    ["id" => 5, "name" => "Спорттық худи", "category" => "Худи", "gender" => "Унисекс", "price" => 17500,
     "color" => "linear-gradient(135deg, #f3e8ff, #d8b4fe)", "icon" => "🧥",
     "description" => "Ішкі жағы жылы, күләпарасы және қалтасы бар",
     "sizes" => ["XS" => 2, "S" => 6, "M" => 8, "L" => 6, "XL" => 3, "XXL" => 0]],
    ["id" => 6, "name" => "Күзгі пальто", "category" => "Сыртқы киім", "gender" => "Әйелдер", "price" => 45000,
     "color" => "linear-gradient(135deg, #fde68a, #d6a75c)", "icon" => "🧥",
     "description" => "Ұзын классикалық пальто, белбеуі бар",
     "sizes" => ["XS" => 1, "S" => 2, "M" => 3, "L" => 0, "XL" => 0, "XXL" => 0]],
    ["id" => 7, "name" => "Жазғы көйлек", "category" => "Көйлек", "gender" => "Әйелдер", "price" => 22000,
     "color" => "linear-gradient(135deg, #fce7f3, #f9a8d4)", "icon" => "👗",
     "description" => "Жеңіл шифон мата, гүлді өрнекпен",
     "sizes" => ["XS" => 4, "S" => 6, "M" => 5, "L" => 3, "XL" => 1, "XXL" => 0]],
    ["id" => 8, "name" => "Спорттық шалбар", "category" => "Шалбар", "gender" => "Унисекс", "price" => 11900,
     "color" => "linear-gradient(135deg, #dcfce7, #86efac)", "icon" => "🩳",
     "description" => "Жаттығуға және серуенге ыңғайлы, белі резеңке",
     "sizes" => ["XS" => 3, "S" => 7, "M" => 9, "L" => 7, "XL" => 5, "XXL" => 3]]
];
