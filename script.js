// SizeFit — клиенттік JavaScript
document.addEventListener("DOMContentLoaded", function () {

    // 1. Мобильді мәзір (кішкене экранда ☰ батырмасы)
    const burger = document.getElementById("burger");
    const nav = document.getElementById("nav");

    if (burger && nav) {
        burger.addEventListener("click", function () {
            nav.classList.toggle("open");
        });
    }

    // Форма астындағы қате (немесе сәтті) мәтінді көрсету
    function showError(form, text, isSuccess) {
        const box = form.querySelector(".form-error");
        if (box) {
            box.textContent = text;
            box.style.color = isSuccess ? "#1d8a45" : "";
            box.hidden = false;
        } else {
            alert(text);
        }
    }

    // 2. Каталогты бетте бірден сүзгілеу (9-аптадағы статикалық бет үшін)
    const liveSearch = document.getElementById("liveSearch");
    const categoryFilter = document.getElementById("categoryFilter");
    const sizeFilter = document.getElementById("sizeFilter");
    const products = document.querySelectorAll(".product-card[data-name]");
    const emptyMessage = document.getElementById("emptyMessage");

    function filterProducts() {
        const text = liveSearch.value.toLowerCase().trim();
        const category = categoryFilter.value;
        const size = sizeFilter.value;
        let visible = 0;

        products.forEach(function (card) {
            const sizes = card.dataset.sizes.split(",");
            const ok =
                card.dataset.name.toLowerCase().includes(text) &&
                (category === "" || card.dataset.category === category) &&
                (size === "" || sizes.includes(size));

            card.hidden = !ok;
            if (ok) visible++;
        });

        if (emptyMessage) emptyMessage.hidden = visible !== 0;
    }

    if (liveSearch && categoryFilter && sizeFilter) {
        liveSearch.addEventListener("input", filterProducts);
        categoryFilter.addEventListener("change", filterProducts);
        sizeFilter.addEventListener("change", filterProducts);
    }

    // 3. Өлшемді JavaScript арқылы анықтау (9-аптадағы статикалық бет үшін)
    const jsSizeForm = document.getElementById("jsSizeForm");

    if (jsSizeForm) {
        const chart = [
            { size: "XS",  chest: [80, 85],   waist: [62, 67] },
            { size: "S",   chest: [86, 91],   waist: [68, 73] },
            { size: "M",   chest: [92, 97],   waist: [74, 79] },
            { size: "L",   chest: [98, 103],  waist: [80, 85] },
            { size: "XL",  chest: [104, 109], waist: [86, 91] },
            { size: "XXL", chest: [110, 116], waist: [92, 98] }
        ];

        function findIndex(value, key) {
            return chart.findIndex(function (row) {
                return value >= row[key][0] && value < row[key][1] + 1;
            });
        }

        jsSizeForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const chest = Number(document.getElementById("chest").value);
            const waist = Number(document.getElementById("waist").value);
            const result = document.getElementById("sizeResult");
            const byChest = findIndex(chest, "chest");
            const byWaist = findIndex(waist, "waist");

            document.querySelectorAll(".size-table tr").forEach(function (tr) {
                tr.classList.remove("highlight");
            });

            if (byChest === -1 || byWaist === -1) {
                showError(jsSizeForm, "Бұл өлшемдер кестеден тыс (кеуде 80–116 см, бел 62–98 см).");
                result.hidden = true;
                return;
            }

            const size = chart[Math.max(byChest, byWaist)].size;
            jsSizeForm.querySelector(".form-error").hidden = true;
            document.getElementById("bigSize").textContent = size;
            result.hidden = false;

            const row = document.querySelector('.size-table tr[data-size="' + size + '"]');
            if (row) row.classList.add("highlight");
        });
    }

    // 4. «Тапсырыс беру» батырмасы (9-апта, статикалық бет)
    document.querySelectorAll(".js-order").forEach(function (btn) {
        btn.addEventListener("click", function () {
            alert("«" + btn.dataset.name + "» таңдалды! Тапсырыс беру формасы келесі кезеңде қосылады.");
        });
    });

    // 5. Тіркелу формасы: құпиясөздер сәйкес пе?
    const registerForm = document.getElementById("registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            const pass = document.getElementById("password").value;
            const confirm = document.getElementById("confirm_password").value;

            if (pass !== confirm) {
                e.preventDefault();
                showError(registerForm, "Құпиясөздер сәйкес келмейді.");
            }
        });
    }

    // 6. Тапсырыс формасы: саны 1–5 аралығында ма?
    document.querySelectorAll(".order-form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            const qty = Number(form.querySelector("[name=quantity]").value);

            if (qty < 1 || qty > 5) {
                e.preventDefault();
                showError(form, "Саны 1-ден 5-ке дейін болуы керек.");
            }
        });
    });
});
