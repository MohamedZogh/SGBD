<?php
session_start();
require_once "connectionBDD.php";

$fctn=$_POST['fct'];
switch($fctn){
    Case "setPerfume":
        setPerfume();
        break;
    Case "putPerfume":
        putPerfume();
        break;
    Case "deletePerfume" :
        deletePerfume();
        break;
    Default:
        echo json_encode(['Error','404']);
        break;
}

function setPerfume(){
    $nom=test_input($_POST['nom']);
    $description=test_input($_POST['description']);
    $prix=test_input($_POST['prix']);
    if ($nom =='' || $description =='' || $prix ==''){
        echo json_encode(['Error', 'Les champs ne peuvent être vides', 'vides']);die;
    }
    elseif(!intval($prix)){
        echo json_encode(['Error', 'Le prix doit etre un nombre '.$prix]);die;
    }
    if(empty($_FILES)) {
        $image = 'noimage.jpg';
    }
    else{
        if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            echo json_encode(['Error','Le fichier envoyer n\'est pas une image :(']);die;
        }
        $name=basename($_FILES['image']['name']);
        $filename = '../../images/Parfums/'.$name;
        $extension = explode('.', $name);
        $ext = ['jpg', 'png', 'jpeg'];
        $image=$name;
        if (in_array($extension, $ext)) {
            echo json_encode(["Error", "Format non accepté (Seulement JPG/JPEG/PNG)."]);die;
        }
        elseif($_FILES['image']['size'] > 10485760) {
            echo json_encode(["Error", "Fichier trop lourd ! (10MB max)"]);die;
        }
        elseif (!file_exists($filename)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $filename);
        }

//        echo json_encode(['Error',"$nom,$description,$prix, $image"]);die;
    }
//echo json_encode(['Error',$image]);die;
    if ($_SESSION['role'] == 'Admin') {
        try {
            $description=str_replace("'","''",$description);
            $nom=str_replace("'","''",$nom);
            $image=str_replace("'","''",$image);
            $conn = connectionBDD();
            $stmt = $conn->prepare("INSERT INTO parfums (nom, description, image, prix) VALUES ('$nom', '$description', '$image', '$prix')");
            // set the resulting array to associative
            if ($stmt->execute() === true) {
                echo json_encode(['true', 'Produit ajouté']);
            }
        } catch (PDOException $e) {
            echo json_encode(['Error',"New Perfume failed: " . $e->getMessage()]);
            die;
        }
    }
    else{
        echo json_encode('Action refusé');
    }
}

function putPerfume(){
    !empty($_POST['nom']) ?  $nom = test_input($_POST['nom']):$nom='';
    !empty($_POST['description']) ?  $description = test_input($_POST['description']) : $description='';
    !empty($_POST['prix']) ?  $prix = test_input($_POST['prix']):$prix='';
    if (empty($_POST['id'])) {
        echo json_encode(['Error', 'Nous manquons de donnée pour éffectué la requête ! (id)']); die;
    }
    elseif(!intval($prix)){
        echo json_encode(['Error', 'Le prix doit etre un nombre '.$prix]);die;
    }
    else{
        $id=test_input($_POST['id']);
    }
    if ($nom =='' && $description =='' && $prix ==''){
        echo json_encode(['Error', 'Modifié au moin un champ', 'vides']);die;
    }
    if(!empty($_FILES)) {
        if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            echo json_encode(['Error','Le fichier envoyé n\'est pas une image :(']);die;
        }
        $name=basename($_FILES['image']['name']);
        $filename = '../../images/Parfums/'.$name;
        $extension = explode('.', $name);
        $ext = ['jpg', 'png', 'jpeg'];
        $image=$name;
//        echo json_encode(['Error',"isset : $nom,$description,$prix, $image"]);die;
        if (in_array($extension, $ext)) {
            echo json_encode(["Error", "Format non accepté (Seulement JPG/JPEG/PNG)."]);die;
        }
        elseif($_FILES['image']['size'] > 10485760) {
            echo json_encode(["Error", "Fichier trop lourd ! (10MB max)"]);die;
        }
        elseif (!file_exists($filename)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $filename);
        }

//        echo json_encode(['Error',"$nom,$description,$prix, $image"]);die;
    }
    else{
        $image='';
    }
        if ($_SESSION['role'] == 'Admin') {
            $exist=getPerfume($id);
            if ($exist[0] == 'true'){
                $nom==''?$nom=$exist[1]['nom']:$nom=$nom;
                $image==''?$image=$exist[1]['image']:$image=$image;
                $description==''?$description=$exist[1]['description']:$description=$description;
                $prix==''?$prix=$exist[1]['prix']:$prix=$prix;
                try {
                    $description=str_replace("'","''",$description);
                    $nom=str_replace("'","''",$nom);
                    $image=str_replace("'","''",$image);
                    $conn = connectionBDD();
                    $stmt = $conn->prepare("UPDATE parfums SET nom='$nom', description='$description', prix='$prix', image='$image' WHERE id='$id'");
                    $stmt->execute();
                    // set the resulting array to associative
                    echo json_encode(['true', 'BDD a jour']);
                } catch (PDOException $e) {
                    echo json_encode(['Error', "Update Perfume failed : " . $e->getMessage()]);
                }
            }
            else{
                echo $exist;
            }
        } else {
            echo json_encode(['Error', 'Action refusé ']);
        }

}

function deletePerfume(){
    $id=test_input($_POST['id']);
    if (filter_var($id, FILTER_VALIDATE_INT)) {
        if ($_SESSION['role'] == 'Admin') {
            $exist=getPerfume($id);
            if ($exist[0]==true) {
                try {
                    $conn = connectionBDD();
                    $stmt = $conn->prepare("DELETE FROM parfums WHERE id='$id'");
                    $stmt->execute();
                    // set the resulting array to associative
                    echo json_encode(['true', 'Le produit a été supprimer !']);
                } catch (PDOException $e) {
                    echo json_encode(['Error', "Update User failed 1: " . $e->getMessage()]);
                }
            }
            else{
                echo json_encode(['Error', 'Le produit saisie est introuvable']);
            }
        } else {
            echo json_encode(['Error', 'Action refusé ']);
        }
    }
    else{
        echo json_encode(['Error', 'Renseignez un pseudo..']);
    }
}

function getPerfume($id){
    try {
        $conn = connectionBDD();
        $stmt = $conn->prepare("SELECT * FROM parfums WHERE id='$id'");
        $stmt->execute();
        // set the resulting array to associative
        $user=$stmt->fetch();
        if ($user){
            return ['true',$user];
        }
        else{
            return json_encode(['Error',"Parfum inconnu !"]);
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