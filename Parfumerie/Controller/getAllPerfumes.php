<?php
require_once "connectionBDD.php";

function getAllPerfumes()
{
    try {
        $conn = connectionBDD();
        $stmt = $conn->prepare("SELECT * FROM parfums");
        $stmt->execute();
        // set the resulting array to associative
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo json_encode("Comminucation BDD failed: " . $e->getMessage());
        die;
    }
}
