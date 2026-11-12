-- SizeFit — Онлайн киім өлшемін таңдау және тапсырыс беру жүйесі
-- Дерекқор мен кестелерді құру скрипті (phpMyAdmin → Import арқылы жүктеледі)

CREATE DATABASE IF NOT EXISTS sizefit
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sizefit;

-- 1. Пайдаланушылар (сатып алушылар мен әкімшілер)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Тауарлар (киімдер)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL,
    gender ENUM('Әйелдер', 'Ерлер', 'Унисекс') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    color VARCHAR(100) NOT NULL,
    icon VARCHAR(10) NOT NULL,
    description TEXT
);

-- 3. Өлшемдер және қоймадағы саны
CREATE TABLE IF NOT EXISTS sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    size_label ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL') NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    UNIQUE (product_id, size_label),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 4. Тапсырыстар
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    size_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    address VARCHAR(255) NOT NULL,
    status ENUM('new', 'confirmed', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES sizes(id) ON DELETE CASCADE
);

-- Тестілік деректер: тауарлар
INSERT INTO products (name, category, gender, price, color, icon, description) VALUES
('Классикалық ақ футболка', 'Футболка', 'Унисекс', 6500, 'linear-gradient(135deg, #f8fafc, #e2e8f0)', '👕', '100% мақта, тығыз тоқылған, күнделікті киюге ыңғайлы'),
('Slim Fit джинсы', 'Шалбар', 'Әйелдер', 18900, 'linear-gradient(135deg, #dbeafe, #93c5fd)', '👖', 'Созылмалы деним, жіңішке пішін, жоғары бел'),
('Жүн свитер', 'Свитер', 'Унисекс', 15900, 'linear-gradient(135deg, #fef3c7, #fcd34d)', '🧶', 'Жұмсақ жүн аралас мата, суық күндерге арналған'),
('Классикалық жейде', 'Жейде', 'Ерлер', 12500, 'linear-gradient(135deg, #e0f2fe, #bae6fd)', '👔', 'Кеңсеге және ресми кездесулерге лайық'),
('Спорттық худи', 'Худи', 'Унисекс', 17500, 'linear-gradient(135deg, #f3e8ff, #d8b4fe)', '🧥', 'Ішкі жағы жылы, күләпарасы және қалтасы бар'),
('Күзгі пальто', 'Сыртқы киім', 'Әйелдер', 45000, 'linear-gradient(135deg, #fde68a, #d6a75c)', '🧥', 'Ұзын классикалық пальто, белбеуі бар'),
('Жазғы көйлек', 'Көйлек', 'Әйелдер', 22000, 'linear-gradient(135deg, #fce7f3, #f9a8d4)', '👗', 'Жеңіл шифон мата, гүлді өрнекпен'),
('Спорттық шалбар', 'Шалбар', 'Унисекс', 11900, 'linear-gradient(135deg, #dcfce7, #86efac)', '🩳', 'Жаттығуға және серуенге ыңғайлы, белі резеңке');

-- Тестілік деректер: әр тауардың өлшемдері мен қоймадағы саны
INSERT INTO sizes (product_id, size_label, stock) VALUES
(1, 'XS', 3),
(1, 'S', 8),
(1, 'M', 10),
(1, 'L', 7),
(1, 'XL', 4),
(1, 'XXL', 2),
(2, 'XS', 2),
(2, 'S', 5),
(2, 'M', 6),
(2, 'L', 4),
(2, 'XL', 0),
(2, 'XXL', 0),
(3, 'XS', 0),
(3, 'S', 4),
(3, 'M', 6),
(3, 'L', 5),
(3, 'XL', 3),
(3, 'XXL', 1),
(4, 'XS', 0),
(4, 'S', 3),
(4, 'M', 5),
(4, 'L', 6),
(4, 'XL', 4),
(4, 'XXL', 2),
(5, 'XS', 2),
(5, 'S', 6),
(5, 'M', 8),
(5, 'L', 6),
(5, 'XL', 3),
(5, 'XXL', 0),
(6, 'XS', 1),
(6, 'S', 2),
(6, 'M', 3),
(6, 'L', 0),
(6, 'XL', 0),
(6, 'XXL', 0),
(7, 'XS', 4),
(7, 'S', 6),
(7, 'M', 5),
(7, 'L', 3),
(7, 'XL', 1),
(7, 'XXL', 0),
(8, 'XS', 3),
(8, 'S', 7),
(8, 'M', 9),
(8, 'L', 7),
(8, 'XL', 5),
(8, 'XXL', 3);

-- Тестілік пайдаланушы (email: test@sizefit.kz, құпиясөз: 12345678)
INSERT INTO users (full_name, email, phone, password_hash, role) VALUES
('Тест Сатып алушы', 'test@sizefit.kz', '+77001112233',
 '$2y$10$fhotUbtq/K.9lKQ4eruw/evA2G6uaxMRIlnZor9jl3zvI9dT58SZK', 'customer');
