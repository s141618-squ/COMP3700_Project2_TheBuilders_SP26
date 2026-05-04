CREATE DATABASE IF NOT EXISTS auto_trade_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE auto_trade_db;


-- ============================================================
-- TABLE 1: cars
-- ============================================================
CREATE TABLE IF NOT EXISTS cars (
    car_id          INT              NOT NULL AUTO_INCREMENT,
    make_model      VARCHAR(100)     NOT NULL,
    year            YEAR             NOT NULL,
    engine          VARCHAR(50)      NOT NULL,
    color           VARCHAR(40)      NOT NULL,
    mileage_km      INT              NOT NULL DEFAULT 0,
    price_omr       DECIMAL(10, 3)   NOT NULL,
    condition_grade ENUM('Excellent','Good','Fair','Poor') NOT NULL DEFAULT 'Good',
    vin             VARCHAR(17)      NOT NULL,
    is_available    TINYINT(1)       NOT NULL DEFAULT 1,
    listed_date     DATE             NOT NULL DEFAULT (CURRENT_DATE),

    PRIMARY KEY (car_id),
    UNIQUE  KEY uq_vin (vin),
    CONSTRAINT chk_year    CHECK (year      >= 1990),
    CONSTRAINT chk_price   CHECK (price_omr  > 0),
    CONSTRAINT chk_mileage CHECK (mileage_km >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO cars (make_model, year, engine, color, mileage_km, price_omr, condition_grade, vin, is_available, listed_date) VALUES
('Toyota Camry 2.5 SE',    2021, '2.5L 4-Cyl',  'Pearl White',    42000,  9500.000, 'Excellent', '1HGBH41JXMN109186', 1, '2026-01-10'),
('Nissan Altima 2.5 SV',   2020, '2.5L 4-Cyl',  'Midnight Black', 61000,  7200.000, 'Good',      '1N4BL4BV0LC123456', 1, '2026-01-22'),
('Toyota Corolla 1.6 XLi', 2019, '1.6L 4-Cyl',  'Silver',         78000,  5800.000, 'Good',      '2T1BURHE0JC091234', 1, '2026-02-05'),
('BMW 520i M Sport',       2022, '2.0L Turbo',   'Mineral Grey',   28000, 18500.000, 'Excellent', 'WBA52BH0XN7E12345', 1, '2026-02-18'),
('Honda Civic RS Turbo',   2021, '1.5L Turbo',   'Sonic Grey',     55000,  8100.000, 'Good',      '2HGFE2F51MH123456', 1, '2026-03-01'),
('Chevrolet Tahoe LS',     2020, '5.3L V8',      'Summit White',   33000, 14200.000, 'Excellent', '1GNSCAKC0LR234567', 0, '2026-03-15'),
('Audi A4 35 TFSI',        2023, '2.0L Turbo',   'Glacier White',  12000, 22000.000, 'Excellent', 'WAUZZZF40PA123789', 1, '2026-04-01');


-- ============================================================
-- TABLE 2: inquiries
-- ============================================================
CREATE TABLE IF NOT EXISTS inquiries (
    inquiry_id   INT          NOT NULL AUTO_INCREMENT,
    full_name    VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL,
    subject      ENUM('buy','sell','service','other') NOT NULL,
    message      TEXT         NOT NULL,
    submitted_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_resolved  TINYINT(1)   NOT NULL DEFAULT 0,

    PRIMARY KEY (inquiry_id),
    CONSTRAINT chk_email CHECK (email LIKE '%@%.%')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO inquiries (full_name, email, subject, message, submitted_at, is_resolved) VALUES
('Ahmed Al Harthi',    'ahmed.harthi@example.com',   'buy',     'I am interested in the Toyota Camry 2021. Is it still available for a test drive?',             '2026-04-10 09:30:00', 1),
('Fatima Al Balushi',  'fatima.balushi@example.com', 'sell',    'I would like to sell my 2018 Honda Accord. How does the valuation process work?',               '2026-04-12 11:15:00', 0),
('Mohammed Al Rashdi', 'm.rashdi@example.com',        'service', 'My car needs an oil change and brake inspection. What is the earliest available slot?',          '2026-04-14 14:00:00', 1),
('Sara Al Habsi',      'sara.habsi@example.com',      'buy',     'Can you provide the full specifications and price breakdown for the BMW 520i listed?',           '2026-04-16 10:45:00', 0),
('Khalid Al Maamari',  'khalid.maamari@example.com', 'other',   'I have a question about your financing options and monthly installment plans for used cars.',     '2026-04-18 08:20:00', 0),
('Noor Al Kindi',      'noor.kindi@example.com',      'buy',     'Do you offer any senior or student discounts on your listed inventory? Please advise.',          '2026-04-20 13:10:00', 0);


-- ============================================================
-- TABLE 3: feedback
-- ============================================================
CREATE TABLE IF NOT EXISTS feedback (
    feedback_id  INT              NOT NULL AUTO_INCREMENT,
    full_name    VARCHAR(100)     NOT NULL,
    email        VARCHAR(150)     NOT NULL,
    phone        VARCHAR(8)       NOT NULL,
    age          TINYINT UNSIGNED NOT NULL,
    service_type ENUM('buying','selling','browsing','maintenance') NOT NULL,
    satisfaction ENUM('excellent','good','average','poor')         NOT NULL,
    rating       TINYINT UNSIGNED NOT NULL,
    comments     VARCHAR(300)     NULL,
    submitted_at DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (feedback_id),
    CONSTRAINT chk_age_fb    CHECK (age    BETWEEN 18 AND 100),
    CONSTRAINT chk_rating_fb CHECK (rating BETWEEN  1 AND  10),
    CONSTRAINT chk_phone_fb  CHECK (phone REGEXP '^[79][0-9]{7}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO feedback (full_name, email, phone, age, service_type, satisfaction, rating, comments, submitted_at) VALUES
('Ahmed Al Harthi',    'ahmed.harthi@example.com',   '91234567', 32, 'buying',      'excellent', 9,  'The staff was very helpful and the car buying experience was smooth and transparent.', '2026-04-11 10:05:00'),
('Fatima Al Balushi',  'fatima.balushi@example.com', '78901234', 27, 'selling',     'good',      7,  'The valuation was fair. Could improve the waiting time at the counter.',              '2026-04-13 12:30:00'),
('Mohammed Al Rashdi', 'm.rashdi@example.com',        '95678901', 45, 'maintenance', 'excellent', 10, 'Excellent service team! My car was ready ahead of schedule.',                        '2026-04-15 15:45:00'),
('Sara Al Habsi',      'sara.habsi@example.com',      '71234987', 24, 'browsing',    'average',   6,  'The website inventory is not always up-to-date. Some listed cars were already sold.','2026-04-17 09:00:00'),
('Khalid Al Maamari',  'khalid.maamari@example.com', '99887766', 38, 'buying',      'good',      8,  'Good overall. Would appreciate more flexible financing options.',                     '2026-04-19 11:20:00'),
('Noor Al Kindi',      'noor.kindi@example.com',      '76543210', 22, 'browsing',    'excellent', 9,  'Very professional showroom and friendly staff. Highly recommend Auto Trade!',         '2026-04-21 14:00:00');


-- Verification queries
SELECT * FROM cars;
SELECT * FROM inquiries;
SELECT * FROM feedback;