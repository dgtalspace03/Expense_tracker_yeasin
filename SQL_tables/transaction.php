<?php
$transaction_sql = "CREATE TABLE IF NOT EXISTS transaction(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description varchar(500) NOT NULL,
    userId int NOT NULL,
    amount int NOT NULL,
    type enum('income','expense') NOT NULL,
    category varchar(200) NOT NULL,
    date DATE NOT NULL,
    created_at DATE NOT NULL DEFAULT (CURRENT_DATE)
)";
