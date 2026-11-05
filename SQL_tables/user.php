<?php
$user_sql= "CREATE TABLE  IF NOT EXISTS user(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(200) NOT NULL,
    email varchar(200) NOT NULL,
    password varchar(500) NOT NULL,
    created_at DATE NOT NULL DEFAULT (CURRENT_DATE) 
)";

?>