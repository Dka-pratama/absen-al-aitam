<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=smks9919_sistemabsen",
        "smks9919_absensi",
        "absensialaitaam"
    );
    echo "DB CONNECT OK";
} catch (PDOException $e) {
    echo $e->getMessage();
}
