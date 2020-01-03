CREATE TABLE user (
    user_id int AUTO_INCREMENT NOT NULL,
    nama varchar(30),
    email varchar(30) NOT NULL,
    password varchar(100) NOT NULL,
    kode_aktifasi varchar(50),
    terdaftar DATE,
    aktif BIT DEFAULT 0,
    PRIMARY KEY (user_id)
);

CREATE TABLE uang (
    uang_id int AUTO_INCREMENT NOT NULL,
    user_id int NOT NULL,
    nama varchar(30),
    bulan varchar(2),
    tahun year,
    jumlah int,
    pocket varchar(11) NOT NULL UNIQUE,
    qrcode varchar(15),
    PRIMARY KEY (uang_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE kategori (
    kategori_id int AUTO_INCREMENT NOT NULL,
    nama varchar(30),
    icon varchar(30),
    PRIMARY KEY (kategori_id)
);

CREATE TABLE pengeluaran (
    pengeluaran_id int AUTO_INCREMENT NOT NULL,
    uang_id int NOT NULL,
    kategori_id int NOT NULL,
    nama varchar(30),
    jumlah int,
    tanggal TIMESTAMP,
    PRIMARY KEY (pengeluaran_id),
    FOREIGN KEY (uang_id) REFERENCES uang(uang_id),
    FOREIGN KEY (kategori_id) REFERENCES kategori(kategori_id)
);

CREATE TABLE pemasukan (
    pemasukan_id int AUTO_INCREMENT NOT NULL,
    uang_id int NOT NULL,
    nama varchar(30),
    jumlah int,
    tanggal TIMESTAMP,
    PRIMARY KEY (pemasukan_id),
    FOREIGN KEY (uang_id) REFERENCES uang(uang_id)
);

INSERT INTO user (email, password, terdaftar, aktif) VALUES
('erwindoq@gmail.com', '$2y$10$D1H.ceQMP8Adh5daN/paJudzPeajtznsgiDNxSpLEagLmHvajT.8y', '2019-11-09', 1);

INSERT INTO kategori VALUES
(1, 'Food and Beverage', 'fa fa-utensils'),
(2, 'Transport', 'fa fa-car'),
(3, 'Groceries', 'fa fa-shopping-basket'),
(4, 'Shopping', 'fa fa-shopping-bag'),
(5, 'Entertainment', 'fa fa-ticket-alt'),
(6, 'Utilities', 'fa fa-briefcase'),
(7, 'Personal', 'fa fa-user-circle'),
(8, 'Education', 'fa fa-graduation-cap'),
(9, 'Gift', 'fa fa-gift'),
(10, 'Cash', 'fa fa-money-bill'),
(11, 'Health', 'fa fa-heartbeat'),
(12, 'Others', 'fa fa-question-circle');