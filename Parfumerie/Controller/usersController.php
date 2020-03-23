<?php
session_start();
require_once "connectionBDD.php";

$fctn=test_input($_POST['function']);

switch($fctn){
    Case "getUser":
        getUser();
        break;
    Case "putUser":
        putUser();
        break;
    Case "deleteUser" :
        deleteUser();
        break;
    Case "logout" :
        logout();
        break;
    Case "setUser" :
        setUser();
        break;
    Default:
        echo json_encode(['Error','404']);
        break;
}

function getUser(){
    $pseudo=test_input($_POST['pseudo']);
    $password=test_input($_POST['password']);
    $password=sha1($password);
    try {
        $conn = connectionBDD();
        $stmt = $conn->prepare("SELECT * FROM users WHERE pseudo= '$pseudo' and password= '$password'");
        $stmt->execute();
        // set the resulting array to associative
        $user=$stmt->fetch();
        if ($user){
            $_SESSION['id']=$user[0];
            $_SESSION['pseudo']=$pseudo;
            $_SESSION['role']=$user[3];
            echo json_encode(['true']);
        }
        else{
            echo json_encode(['Error',"Identifiants incorrects"]);
        }
    } catch (PDOException $e) {
        echo json_encode(['Error',"Communication BDD failed: " . $e->getMessage()]);
        die;
    }
}

function setUser(){
    $pseudo=test_input($_POST['pseudo']);
    $password=test_input($_POST['password']);
    $password=sha1($password);
    $role=test_input($_POST['role']);
    $sexe=test_input($_POST['sexe']);
    if ($sexe != 0 && $sexe !=1){
        $sexe=0;
    }
    if ($pseudo =='' || $password =='' || $sexe==''){
        echo json_encode(['Error', 'Les champs ne peuvent être vides', 'vides']);die;
    }
    if ( $role == '' || $role == '0'){
        $role = 'User';
    }
    if ($pseudo && $password && $role) {
        if ($_SESSION['role'] == 'Admin') {
            try {
                // verifier que le pseudo n'est pas déjà pris :
                $conn = connectionBDD();
                $stmt = $conn->prepare("SELECT * FROM users WHERE pseudo= '$pseudo'");
                $stmt->execute();
                $user=$stmt->fetch();
                if ($user){
                    $_SESSION['id']=$user[0];
                    $_SESSION['pseudo']=$pseudo;
                    $_SESSION['role']=$user[3];
                    echo json_encode(['Error',"Le pseudo n'est pas disponible"]);die;
                }
                $conn2 = connectionBDD();
                $stmt2 = $conn2->prepare("INSERT INTO users (pseudo, password, role, type_id)
                                        VALUES ('$pseudo', '$password', '$role', '$sexe')");
                $stmt2->execute();
                // set the resulting array to associative
                    echo json_encode(['true']);
            } catch (PDOException $e) {
                echo json_encode(['Error', "New User failed 1: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(['Error', 'Action refusé ']);
        }
    }
    else{
        echo json_encode(['Error', 'Les identifiants ne peuvent être vide..']);
    }
}

function putUser(){
    $password=test_input($_POST['password']);
    $password=sha1($password);
    $role=test_input($_POST['role']);
    $pseudo=test_input($_POST['pseudo']);
    if ($pseudo ==''){
        echo json_encode(['Error', 'Le pseudo doit être renseigné', 'vides']);die;
    }
    elseif ($password =='' && $role ==''){
        echo json_encode(['Error', 'Renseignez au moin le password ou le role', 'vides']);die;
    }
    $password =='' ? $password ='0': $password=$password;
    $role =='' ? $role ='0': $role=$role;
    if ($password!='0' && $role!='0'){
        $query="UPDATE users SET password='$password', role='$role' WHERE pseudo='$pseudo'";
    }
    elseif ($role!='0'){
        $query="UPDATE users SET role='$role' WHERE pseudo='$pseudo'";
    }
    elseif ($password!='0'){
        $query="UPDATE users SET password='$password' WHERE pseudo='$pseudo'";
    }
        if ($_SESSION['role'] == 'Admin') {
            $exist=getIfUser($pseudo);
            if ($exist == 'existe'){
                try {
                    $conn = connectionBDD();
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    // set the resulting array to associative
                        echo json_encode(['true', 'BDD a jour']);
                } catch (PDOException $e) {
                    echo json_encode(['Error', "Update User failed : " . $e->getMessage()]);
                }
            }
            else{
                echo $exist;
            }
        } else {
            echo json_encode(['Error', 'Action refusé ']);
        }
}

function deleteUser(){
    $pseudo=test_input($_POST['pseudo']);
    if ($pseudo) {
        if ($_SESSION['role'] == 'Admin') {
            $exist=getIfUser($pseudo);
            if ($exist == 'existe') {
                try {
                    $conn = connectionBDD();
                    $stmt = $conn->prepare("DELETE FROM users WHERE pseudo='$pseudo'");
                    $stmt->execute();
                    // set the resulting array to associative
                    echo json_encode(['true']);
                } catch (PDOException $e) {
                    echo json_encode(['Error', "Update User failed 1: " . $e->getMessage()]);
                }
            }
            else{
                echo $exist;
            }
        } else {
            echo json_encode(['Error', 'Action refusé ']);
        }
    }
    else{
        echo json_encode(['Error', 'Renseignez un pseudo..']);
    }
}

function logout(){
    $_SESSION['role']='guest';
    $_SESSION['panier']=array();
    $_SESSION['panier']['libelleProduit'] = array();
    $_SESSION['panier']['qteProduit'] = array();
    $_SESSION['panier']['prixProduit'] = array();
    echo json_encode(['true', $_SESSION['role']]);
}

function getIfUser($pseudo){
    try {
        $conn = connectionBDD();
        $stmt = $conn->prepare("SELECT role FROM users WHERE pseudo= '$pseudo'");
        $stmt->execute();
        // set the resulting array to associative
        $user=$stmt->fetch();
        if ($user){
            return 'existe';
        }
        else{
            return json_encode(['Error',"Utilisateur inexistant"]);
        }
    } catch (PDOException $e) {
        return json_encode(['Error',"Communication BDD failed: " . $e->getMessage()]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}