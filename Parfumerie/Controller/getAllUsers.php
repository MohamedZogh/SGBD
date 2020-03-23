<?php
require_once "connectionBDD.php";

function getAllUsers()
{
    try {
        $conn = connectionBDD();
        $stmt = $conn->prepare("SELECT pseudo, sexe, role FROM users
                                          INNER JOIN sexe ON users.type_id=sexe.id_sexe
                                ");
        $stmt->execute();
        // set the resulting array to associative
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo json_encode("Comminucation BDD failed: " . $e->getMessage());
        die;
    }
}
