<?php
session_start();
if ($_SESSION['role'] != 'Admin'){
    header('Location: index.php');
    exit();
}
require_once 'Controller/getAllPerfumes.php';
$articles=getAllPerfumes();
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
    <link rel="stylesheet" href="js/dropzone/dist/min/dropzone.min.css">
</head>
<body id="products-body">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Connexion</a>
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
            if (isset($_SESSION['role']) && $_SESSION['role']== 'Admin' || $_SESSION['role']== 'User') {
                echo'<div class="dropdown-divider"></div>
                                <button type="button" class="btn" onclick="logout()" style="width:100% !important; background-color: #1c8adb">Deconnexion</button>
                            </div>
                        </li>';
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
    <h1>Gestion des Produits :</h1>
<div id="container-products">
    <div id="products">
        <?php
            foreach ($articles as $article){?>
            <div class="card" data-toggle="modal" data-target="#exampleModalCenter" data-prix="<?php echo $article['prix'];?>" data-description="<?php echo $article['description'];?>" data-name="<?php echo $article['nom'];?>" data-id="<?php echo $article['id'];?>" style="width: 18rem;">
                <img class="card-img-top" src="../images/Parfums/<?php echo $article['image'];?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $article['nom'];?><span><?php echo $article['stamp'];?></span></h5>
                    <p class="card-text"><?php echo $article['description'];?></p>
                    <span id="card-price"><?php echo $article['prix'];?>€</span>
<!--                    <button id="addToCart"> Ajouter au panier </button>-->
                </div>
            </div>
            <?php
            }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-primary gestion" data-function="setPerfume" data-gestion="Ajouter" >Ajouter</button>
                <button type="button" id="putButton" class="btn btn-secondary gestion" data-function="putPerfume" data-gestion="Modifier" >Modifier</button>
                <button type="button" class="btn btn-success gestion" data-function="deletePerfume" data-gestion="Delete" >Supprimer</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="input-group mb-3 input-gestion input-suppression">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
                        </div>
                        <input type="text" id="modal-name" name="nom" class="form-control" placeholder="Required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                    <div class="input-group mb-3 input-gestion ">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                        </div>
                        <input type="text" id="modal-description" name="description" class="form-control" placeholder="Required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="input-group mb-3 input-gestion">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Prix</label>
                        </div>
                        <input type="number" id="modal-price" name="prix" class="form-control" placeholder="Required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
    <!--                <form action="/file-upload" class="dropzone" id="modal-file">-->
                        <input type="file" id="modal-file" name="image" class="input-gestion" value="">
    <!--                </form>-->
                    <input type="hidden" id="modal-id" name="function" value="">
                    <input type="hidden" id="modal-function" name="function" value="putPerfume">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit-gestion" class="btn btn-primary" onclick="Perfume()">Modifier</button>
                </div>
        </div>
    </div>
</div>
<script src="js/dropzone/dist/min/dropzone.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="js/users.js" ></script>
<script src="js/perfumes.js" ></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('.gestion').css("background-color",'grey');
        $('#putButton').css("background-color",'green');

        $('.card').click(function(){
            var name= $(this).attr("data-name");
            $('#modal-name').val(name);
            var id= $(this).attr("data-id");
            $('#modal-id').val(id);
            var prix= $(this).attr("data-prix");
            $('#modal-price').val(prix);
            var description= $(this).attr("data-description");
            $('#modal-description').val(description);
        });

        $('.gestion').click(function(){
            var fct= $(this).attr("data-function");
            $('#modal-function').val(fct);
            $('.gestion').css("background-color",'grey');
            $(this).css("background-color",'green');
            var gestion= $(this).attr("data-gestion");
            gestion == 'Delete' ? ($('.input-gestion').hide()) : $('.input-gestion').show()
            $('#submit-gestion').html(gestion);
        });
    });
</script>
</body>
</html>
