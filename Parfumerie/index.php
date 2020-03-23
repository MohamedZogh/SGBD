<?php
session_start();
if (!isset($_SESSION['role'])){
    if (isset($_GET['guest'])){
        $_SESSION['role']='Guest';
    }
    else{
        header('Location: http://localhost/IT-akademy/Parfumerie/login.php');
        exit();
    }
}
require_once("Controller/fonctions-panier.php");
require_once 'Controller/getAllPerfumes.php';
require_once 'Controller/getAllUsers.php';
include_once 'facture.php';

$articles=getAllPerfumes();
$users=getAllUsers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="Style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lilita+One&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
            <a class="navbar-brand" href="#">Parfumerie</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'User') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#last-perfumes">Nos dernier parfums</a>
                    </li>
                    <?php
                        if (isset($_SESSION['role']) && $_SESSION['role']== 'Admin' || $_SESSION['role']== 'User') {
                        echo'<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    User
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #1c8adb">';
                            if (isset($_SESSION["role"]) && $_SESSION["role"]== "Admin") {
                                echo '<button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter" style="width:100% !important; background-color: #1c8adb; ">Gestion</button>';
                            }
                        }
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin' || $_SESSION['role']== 'User') {
                            echo'<div class="dropdown-divider"></div>
                                    <button type="button" class="btn" onclick="logout()" style="width:100% !important; background-color: #1c8adb">Deconnexion</button>
                                </div>
                            </li>';
                        }
                    ?>
                    <?php
                    if ($_SESSION["role"]== "User" || $_SESSION["role"]== "Admin") {
                        echo '<i class="fas fa-shopping-basket" data-toggle="modal" data-target="#exampleModal2"></i><span style="color: red;">'.compterArticles().'</span>';
                    }
                    ?>
                </ul>
                <?php
                if (isset($_SESSION["role"]) && $_SESSION["role"]== "Admin") {
                    echo '<div class="my-2 my-lg-0">
                            <a href="product.php" target="_blank">Gestion des Produits</a>
                        </div>';
                }?>
            </div>
        </nav>
        <img id="background-home" src="../images/parfum.jpg">
    </header>

    <div id="last-perfumes">
        <div id="decoration-left" class="decoration"></div>
        <div id="decoration-right" class="decoration"></div>
        <div id="container-last-perfumes">
            <div id="container-left">
                <h2><span>ONE</span><span>MILLION</span></h2>
                <div id="carousel2" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        <?php
                        $quantity= sizeof($articles);
                        if ($quantity <=10){
                            $start =0;
                        }
                        else{
                            $start=$quantity-10;
                        }
                        for ($i = $start; $i < $quantity; $i++){
                            if ($i == 0){
                                echo'<div class="container-detail-perfume carousel-item active">
                                        <h1 id="carousel-perfume-name">'.$articles[$i]["nom"].'</h1>
                                        <span id="carousel-perfume-description">'.$articles[$i]["description"].'</span>
                                        <span id="carousel-perfume-prix">'.$articles[$i]["prix"].'€</span>
                                    </div>';
                            }
                            else {
                                echo'<div class="container-detail-perfume carousel-item">
                                        <h1 id="carousel-perfume-name">'.$articles[$i]["nom"].'</h1>
                                        <span id="carousel-perfume-description">'.$articles[$i]["description"].'</span>
                                        <span id="carousel-perfume-prix">'.$articles[$i]["prix"].'€</span>                                                                              
                                    </div>';
                            }
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev js-invisible" id="carousel2-prev" href="#carousel2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next js-invisible" id="carousel2-next" href="#carousel2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <h3>OneMillion</h3>
            </div>
            <div id="container-right">
                <h1>Nos derniers ajouts :)</h1>
            </div>
            <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <?php
                        $quantity= sizeof($articles);
                        if ($quantity <=10){
                            $start =0;
                        }
                        else{
                            $start=$quantity-10;
                        }
                        for ($i = $start; $i < $quantity; $i++){
                            if ($i == 0){
                                echo'<div class="carousel-item active" data-last-name="'.$articles[$i]["nom"].'" data-last-description="'.$articles[$i]["description"].'">
                                        <img class="d-block w-100" src="../images/Parfums/'. $articles[$i]["image"].'" alt="Parfum">
                                        <a class="add-to-cart" href="index.php?action=ajout&l='.$articles[$i]["nom"].'&q=1&p='.$articles[$i]["prix"].'&#last-perfumes">Ajouter au panier</a>
                                    </div>
                                    ';
                            }
                            else {
                                echo'<div class="carousel-item" data-last-name="'.$articles[$i]["nom"].'" data-last-description="'.$articles[$i]["description"].'">
                                        <img class="d-block w-100" src="../images/Parfums/'. $articles[$i]["image"].'" alt="Parfum">
                                        <a class="add-to-cart" href="index.php?action=ajout&l='.$articles[$i]["nom"].'&q=1&p='.$articles[$i]["prix"].'&#last-perfumes">Ajouter au panier</a>
                                    </div>
                                    ';
                            }
                        }
                    ?>
                </div>
                <a class="carousel-control-prev js-visible-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon js-visible" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next js-visible-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon js-visible" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
<?php    if (isset($_SESSION["role"]) && $_SESSION["role"]== "Admin") {
    echo '
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-primary gestion" data-gestion="addUser()" >Inscrire</button>
                    <button type="button" class="btn btn-secondary gestion" data-gestion="updateUser()" >Modifier</button>
                    <button type="button" class="btn btn-success gestion" data-gestion="deleteUser()" >Supprimer</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                        Liste
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3 modal-pseudo input-gestion input-suppression">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Pseudo</span>
                        </div>
                        <input type="text" id="modal-pseudo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="input-group mb-3 modal-password input-gestion ">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                        </div>
                        <input type="text" id="modal-password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="input-group mb-3 input-gestion">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Role</label>
                        </div>
                        <select class="custom-select" id="modal-role">
                            <option selected value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 input-gestion">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Sexe</label>
                        </div>
                        <select class="custom-select" id="modal-sexe">
                            <option selected value="0">Homme</option>
                            <option value="1">Femme</option>
                        </select>
                    </div>
                    <input type="hidden" id="choice-gestion" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit-gestion" class="btn btn-primary" onclick="addUser()">Save changes</button>
                </div>
            </div>
        </div>
    </div>';
    echo '
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Liste des Utilisateurs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-dark">
                  <tbody>';
                    foreach($users as $user){
                        echo'
                            <tr id="tr'.$user["pseudo"].'" class="liste-user" data-pseudo="'.$user["pseudo"].'" data-sexe="'.$user["sexe"].'" data-role="'.$user["role"].'" data-dismiss="modal">
                                <td>'.$user["pseudo"].'</td>
                                <td>'.$user["sexe"].'</td>
                            </tr>';
                    }
                    echo'
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>  
          ';
    }
include_once 'panier.php';
    ?>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="js/users.js" ></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.input-group').hide();
            $('.gestion').click(function(){
                $('.gestion').css("background-color",'grey');
                $(this).css("background-color",'green');
                var gestion= $(this).attr("data-gestion");
                gestion == 'deleteUser()' ? ($('.input-gestion').hide(), $('.input-suppression').show()) : $('.input-gestion').show()
                $('#submit-gestion').attr("onclick",gestion);
            });
            $('.js-visible-prev').click( function () {
                $('#carousel2-prev').click()
            })
            $('.js-visible-next').click( function () {
                $('#carousel2-next').click()
            })
            <?php if ( $_SESSION["role"]== "Admin") {
            echo "
            $('body').on('click', '.liste-user', function() {
                var pseudo= $(this).attr('data-pseudo');
                $('#modal-pseudo').val(pseudo);
                var sexe= $(this).attr('data-sexe');
                sexe=='Homme' ? sexe=0 : sexe=1
                $('#modal-sexe').val(sexe);
                var role= $(this).attr('data-role');
                role=='User' ? role=1 : role=2
                $('#modal-role').val(role);
            })";
            }?>

            // Ajouter au panier si existant apres plusieurs d'affiler sur un meme boutton
            $('.add-to-cart').click(function () {
                var href=$(this).attr("href");
                var list=href.split(" ");
                var last_element = list.length-1;
                var encodehref='';
                list.forEach( (item, index) => {
                    if (index != last_element) {
                        encodehref += item + '%20'
                    }
                    else{
                        encodehref+=item;
                    }
                })
                var str = window.location.href;
                var url = str.split("Parfumerie/");
                var urlactive= url[1];
                console.log(urlactive)
                console.log(encodehref)
                if (encodehref == urlactive){
                    location.reload();
                }
            })
        });
    </script>
    <script src="https://kit.fontawesome.com/b6cf056886.js" crossorigin="anonymous"></script>
</body>
</html>
