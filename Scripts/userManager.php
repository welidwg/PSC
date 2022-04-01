<?php
require_once("./utiles.php");
header('Content-Type: application/json');
$connect = Connect();

if (isset($_GET["Add"])) {
    $code = $_POST["code"];
    $dateAbonnement = date("Y-m-d", strtotime($_POST["dateAbonnement"]));
    $Nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $pays = $_POST["pays"];
    $ville = $_POST["ville"];
    $prof = $_POST["prof"];
    $adresse = $_POST["adresse"];
    $CodeP = $_POST["CodeP"];
    $dateNaiss = date("Y-m-d", strtotime($_POST["dateNaissance"]));
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $dateExp = date("Y-m-d", strtotime("+ 1 year", strtotime($dateAbonnement)));
    $creation = date("Y-m-d");
    $categ = $_POST["categ"];
    $emplacement = $_POST["emp"];
    $sexe = $_POST["sexe"];
    $year = date("Y", strtotime($dateNaiss));

    $checkCode = GetNumRows("SELECT * from empr where empr_cb='$code'");
    if ($checkCode == 1) {
        echo json_encode("Code déjà utlisé !");
        exit();
    }
    $checkEmail = GetNumRows("SELECT * from userAccounts where email='$email'");
    if ($checkEmail == 1) {
        echo json_encode("Email déjà utlisé !");
        exit();
    }
    $checkTel = GetNumRows("SELECT * from empr where empr_tel1='$tel'");
    if ($checkTel == 1) {
        echo json_encode("Téléphone déjà utlisé !");
        exit();
    }
    if (mysqli_query($connect, "INSERT INTO empr (empr_cb,empr_nom,empr_prenom,empr_adr1,empr_cp,empr_ville,empr_pays,empr_mail,empr_tel1,empr_prof,empr_creation,empr_modif,empr_date_adhesion,empr_date_expiration,empr_location,empr_categ,empr_codestat,empr_sexe,empr_year)
     values ('$code','$Nom','$prenom','$adresse','$CodeP','$ville','$pays','$email','$tel','$prof','$creation','$creation','$dateAbonnement','$dateExp',9,$categ,$emplacement,$sexe,$year  ) ")) {

        echo json_encode("Ajouté avec succées !");
    } else {
        echo json_encode(mysqli_error($connect));
    }
}
