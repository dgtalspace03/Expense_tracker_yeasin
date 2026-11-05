<?php include("pdo_connect.php")?>
<?php include("SQL_tables/user.php")?>
<?php
try {
    $pdo->exec($user_sql);
    echo "Migration Successfull";
} catch (\Throwable $th) {
    echo "Migration Failed" . $th;
}

?>