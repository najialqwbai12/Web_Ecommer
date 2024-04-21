<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

$options = array(
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND       => "SET NAMES UTF8" // تعيين ترميز الحروف إلى UTF-8
);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,$options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       //echo "تم الاتصال بنجاح";
   // echo " Yoe Are Coonect Welacome To Database ";
} catch(PDOException $e) {
    echo "فشل الاتصال: " . $e->getMessage();
}

?>