<!DOCTYPE html>
<html>
<?php
session_start();
require_once("../Scripts/utiles.php");
$appName = "M-R-M |";
if (isset($_SESSION["login"])) {
    $avatar = $_SESSION["avatar"];
    $id = $_SESSION["idUser"];
    $role = $_SESSION["role"];
    if ($role == 0) {
        $empr = GetEMPR($id);
    }
    $usr = GetUser($id);
}

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Amiri&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../assets/css/untitled.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link rel="shortcut icon" href="../assets/img/logobiblio.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        ::-webkit-scrollbar {
            width: 7px;
            transition: .2s;

        }


        /* Track */
        ::-webkit-scrollbar-track {
            background: white;
            transition: .2s;

        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #f2b849;
            transition: .2s;

        }

        /* Handle on hover */
    </style>
    <script>
        function ReloadIndex() {
            return window.location.href = "./index.php";
        }
    </script>
    <style>
        #loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #f9fafa;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="loader">
            <div class="mx-auto " style="display: flex;flex-direction: column;padding: 20px;color:black;align-items: center;margin: 11px">
                <img src="../assets/img/logobiblio[black].png" alt=" MRM" style="width: 100px">
                <br>
                Chargement en cours..

                <div class="spinner-border  " style="color:#f2b849" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


        </div>
        <script>
            $(function() {

                $(window).on("scroll", function() {

                    if (window.scrollY > 50) {
                        $("#navFix").css("position", "sticky");
                        $("#navFix").css("top", "0");
                    } else {

                        $("#navFix").css("position", "relative");
                    }
                });
            });
        </script>
        <nav class="navbar navbar-dark shadow-lg d-none d-md-none d-lg-flex align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background: #eaeaeb;">
            <div class="container-fluid d-flex flex-column p-0" id="navFix">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.html">
                    <div class="sidebar-brand-icon rotate-n-15"><img class="rounded border shadow-sm d-lg-flex align-items-lg-center" src="../assets/img/logobiblio[black].png" style="width: 40px;transform: rotate(15deg) skew(0deg);"></div>
                    <div class="sidebar-brand-text mx-3"></div>
                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="./index.php" style="color: rgb(43,42,41);"><i class="fa fa-home" style="color: rgb(43,42,41);"></i><span>Accueil</span></a> </li>

                    <li class="nav-item"><a class="nav-link" href="./bibliotheque.php" style="color: rgb(43,42,41);"><i class="fas fa-book-open" style="color: rgb(43,42,41);"></i><span>Bibilothèque</span></a></li>
                    <?php if (!isset($_SESSION["login"])) { ?>
                        <li class="nav-item"><a class="nav-link" href="./login.php" style="color: rgb(43,42,41);"><i class="fas fa-sign-in-alt" style="color: rgb(43,42,41);"></i><span><span>Se connecter</span></span></a></li>
                        <li class="nav-item"><a class="nav-link" href="./register.php" style="color: rgb(43,42,41);"><i class="fas fa-user-plus" style="color: rgb(43,42,41);"></i><span>Créer un compte</span></a></li>
                    <?php } ?>
                    <?php if (isset($_SESSION["login"]) && ($role == 1 || $role == 2)) { ?>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item"><a class="nav-link" href="./AjouterAdherant.php" style="color: rgb(43,42,41);"><i class="fas fa-user-plus" style="color: rgb(43,42,41);"></i><span>Ajouter un adhérant</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="./listeAdherant.php" style="color: rgb(43,42,41);"><i class="fas fa-users" style="color: rgb(43,42,41);"></i><span>Liste des adhérants</span></a></li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item" id="addBook"><a class="nav-link" style="color: rgb(43,42,41);cursor: pointer;"><i class="fas fa-plus" style="color: rgb(43,42,41);"></i><span>Ajouter un document</span></a></li>
                        <script>
                            $(function() {
                                $("#addBook").on("click", (e) => {
                                    alertify.prompt("Ajouter un document", "Veuillez d'abord ajouter la référence de document", "", (e, val) => {

                                        if (val == "") {
                                            alertify.error("Veuillez intoduire une référence")
                                        } else {
                                            window.location.href = `./AjouterDocument.php?ref=${val}`;
                                        }
                                    }, (e) => {}).set("type", "number")
                                })
                            });
                        </script>
                        <?php if ($role == 1) { ?>

                            <li class="nav-item"><a class="nav-link" href="./AjouterUser.php" style="color: rgb(43,42,41);"><i class="fas fa-users-cog" style="color: rgb(43,42,41);"></i><span>Ajouter un utilisateur</span></a></li>

                        <?php } ?>

                    <?php } ?>




                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button" style="color: rgb(43,42,41);background: rgb(43,42,41);"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper" style="background: #e4dedf;">
            <div id="content" style="border-color: rgb(249,250,250);background: url(&quot;../assets/img/background.png&quot;) no-repeat, #e4dedf;background-size: cover, auto;">
                <nav class="navbar navbar-light navbar-expand-lg shadow-lg d-lg-flex d-xl-flex d-xxl-flex" style="background: url(&quot;https://cdn.bootstrapstudio.io/placeholders/1400x800.png&quot;), #f9fafa;box-shadow: 0px 0px;">
                    <div class="container-fluid"><a class="navbar-brand d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block flex-shrink-1" href="index.html" style="color: #7a6a5e;font-family: Amiri, serif;font-size: 17px;"><strong>Médiathèque Régionale de Monastir</strong><br></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1" style="background: #7a6a5e;border-color: rgb(122,106,94);"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse d-lg-flex d-xl-flex d-xxl-flex justify-content-lg-end justify-content-xl-end justify-content-xxl-end" id="navcol-1" style="font-size: 25px;">
                            <ul class="navbar-nav" style="margin: 0px;padding: 0px;">
                                <li class="nav-item"></li>
                                <li class="nav-item dropdown no-arrow">
                                    <ul class="navbar-nav">
                                        <li class="nav-item d-print-none d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none" style="padding: 8px;font-size: 2.5vh;"><a class="nav-link" href="./index.php" style="font-size: 2.4vh;">Accueil</a></li>
                                        <li class="nav-item d-print-none d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none" style="padding: 8px;font-size: 2.5vh;"><a class="nav-link" href="./bibliotheque.php" style="font-size: 2.4vh;">Bibliothèque</a></li>
                                        <li class="nav-item d-print-none d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none" style="padding: 8px;font-size: 2.5vh;"><a class="nav-link" href="./login.php" style="font-size: 2.4vh;">Connexion</a></li>
                                        <li class="nav-item d-print-none d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none" style="padding: 8px;font-size: 2.5vh;"><a class="nav-link" href="./register.php" style="font-size: 2.4vh;">Créer un compte</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"></li>
                                <li class="nav-item"></li>
                            </ul>
                        </div>
                        <?php if (isset($_SESSION["login"]) && ($role != 1 && $role != 2)) { ?>
                            <div class="dropdown"><a class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="padding: 0px;color: #ef9c1f;font-weight: bold;"><img class="rounded-circle border rounded-0" style="width: 35px;height: 35px;margin: 0px;" src="<?php if ($usr["avatar"] != "") echo "../assets/img/avatars/" . $usr["avatar"];
                                                                                                                                                                                                                                                                                                else echo "../assets/img/avatar.png"; ?>"> <?php $nom = explode(" ", $empr["empr_prenom"]);
                                                                                                                                                                                                                                                                                                                                            echo $nom[0] . " " .
                                                                                                                                                                                                                                                                                                                                                $empr["empr_nom"]  ?></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="far fa-user-circle" style="margin-right: 5px;"></i>Mon profile</a>
                                    <a class="dropdown-item" href="./favs.php">
                                        <i class="fas fa-book-reader" style="margin-right: 5px;width: 13px;"></i>
                                        Mes Favories
                                    </a>

                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="../Scripts/auth.php?Logout"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i>Déconnexion</a>
                                </div>
                            </div>
                        <?php } else if (isset($_SESSION["login"]) && ($role == 1 || $role == 2)) {
                        ?>
                            <div class="dropdown">
                                <a class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="padding: 0px;color: #ef9c1f;font-weight: bold;">
                                    <img class="rounded-circle border rounded-0" style="width: 35px;height: 35px;margin: 0px;" src="<?php if ($usr["avatar"] != "") echo "../assets/img/avatars/" . $usr["avatar"];
                                                                                                                                    else echo "../assets/img/avatar.png"; ?>"><?= $usr["nom"]; ?></a>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="far fa-user-circle" style="margin-right: 5px;"></i>
                                        Mon profile
                                    </a>
                                    <a class="dropdown-item" href="./favs.php">
                                        <i class="fas fa-book-reader" style="margin-right: 5px;width: 13px;"></i>
                                        Mes Favories
                                    </a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="../Scripts/auth.php?Logout"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i>Déconnexion</a>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </div>
                </nav>
                <div class="container hero">

                    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
                    <script src="../assets/js/bs-init.js"></script>
                    <script src="../assets/js/theme.js"></script>
                    <script>
                        window.addEventListener("load", () => {
                            setTimeout(() => {
                                $("#loader").fadeOut();
                            }, 500);
                        });
                    </script>

</html>