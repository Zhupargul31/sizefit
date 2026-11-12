<?php
// Өлшемдер кестесі (см) және өлшемді анықтау функциясы.
// Бұл файл size.php бетіне include арқылы қосылады.

$sizeChart = [
    ["size" => "XS",  "chest_from" => 80,  "chest_to" => 85,  "waist_from" => 62, "waist_to" => 67],
    ["size" => "S",   "chest_from" => 86,  "chest_to" => 91,  "waist_from" => 68, "waist_to" => 73],
    ["size" => "M",   "chest_from" => 92,  "chest_to" => 97,  "waist_from" => 74, "waist_to" => 79],
    ["size" => "L",   "chest_from" => 98,  "chest_to" => 103, "waist_from" => 80, "waist_to" => 85],
    ["size" => "XL",  "chest_from" => 104, "chest_to" => 109, "waist_from" => 86, "waist_to" => 91],
    ["size" => "XXL", "chest_from" => 110, "chest_to" => 116, "waist_from" => 92, "waist_to" => 98]
];

// Өлшем ретін табу (XS = 0, S = 1, ...). Табылмаса -1 қайтарады.
function sizeIndex($value, $fromKey, $toKey, $chart) {
    foreach ($chart as $i => $row) {
        if ($value >= $row[$fromKey] && $value <= $row[$toKey] + 0.99) {
            return $i;
        }
    }
    return -1;
}

// Кеуде және бел өлшемі бойынша ыңғайлы өлшемді ұсыну.
// Екеуі әртүрлі өлшем көрсетсе — үлкенін таңдаймыз (киім тар болмауы үшін).
function recommendSize($chest, $waist, $chart) {
    $byChest = sizeIndex($chest, "chest_from", "chest_to", $chart);
    $byWaist = sizeIndex($waist, "waist_from", "waist_to", $chart);

    if ($byChest === -1 || $byWaist === -1) {
        return null;
    }

    return $chart[max($byChest, $byWaist)]["size"];
}
