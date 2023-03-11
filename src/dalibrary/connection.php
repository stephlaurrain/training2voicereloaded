<?php

$config = include("config.php");
try {
    $db = new PDO($config["db"], $config["user"], $config["pass"], $config["options"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Statement failed: " . $e->getMessage();    
}
    