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
        http_response_code(500);
        echo json_encode(array("msg" => "Code déjà utilisé !"));
        exit();
    }
    $checkEmail = GetNumRows("SELECT * from empr where empr_mail='$email'");
    if ($checkEmail == 1) {
        http_response_code(500);
        echo json_encode(array("msg" => "Email déjà utilisé !"));

        exit();
    }
    $checkTel = GetNumRows("SELECT * from empr where empr_tel1='$tel'");
    if ($checkTel == 1) {
        http_response_code(500);
        echo json_encode(array("msg" => "Téléphone déjà utilisé !"));

        exit();
    }
    if (mysqli_query($connect, "INSERT INTO empr (empr_cb,empr_nom,empr_prenom,empr_adr1,empr_cp,empr_ville,empr_pays,empr_mail,empr_tel1,empr_prof,empr_creation,empr_modif,empr_date_adhesion,empr_date_expiration,empr_location,empr_categ,empr_codestat,empr_sexe,empr_year)
     values ('$code','$Nom','$prenom','$adresse','$CodeP','$ville','$pays','$email','$tel','$prof','$creation','$creation','$dateAbonnement','$dateExp',9,$categ,$emplacement,$sexe,$year  ) ")) {
        http_response_code(200);
        echo json_encode(array("msg" => "Ajouté avec succées!"));
    } else {
        http_response_code(500);
        echo json_encode(array("msg" => "Erreur de serveur", "error" => mysqli_error($connect)));
    }
} else if (isset($_GET["edit"])) {
    $dateAbonnement = date("Y-m-d", strtotime($_POST["dateAbonnement"]));
    $idEmp = $_POST["id_empr"];
    $Nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $pays = $_POST["pays"];
    $ville = $_POST["ville"];
    $prof = $_POST["prof"];
    $adresse = $_POST["adresse"];
    $CodeP = $_POST["CodeP"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $dateExp = date("Y-m-d", strtotime("+ 1 year", strtotime($dateAbonnement)));
    $updated = date("Y-m-d");
    $categ = $_POST["categ"];
    $emplacement = $_POST["emp"];
    $sexe = $_POST["sexe"];
    if ($email != "") {
        $checkEmail = GetNumRows("SELECT * from empr where empr_mail like '$email' and id_empr!=$idEmp");
        if ($checkEmail == 1) {
            http_response_code(500);

            echo json_encode("Email déjà existant");
            exit();
        }
    }
    if ($tel != "") {
        $checkTel = GetNumRows("SELECT * from empr where empr_tel1='$tel' and id_empr!=$idEmp");
        if ($checkTel == 1) {
            http_response_code(500);

            echo json_encode("Téléphone déjà existant");
            exit();
        }
    }

    $sql = "UPDATE empr SET empr_nom='$Nom',empr_prenom='$prenom',empr_adr1='$adresse',empr_cp='$CodeP',empr_ville='$ville',empr_pays='$pays',empr_mail='$email',empr_tel1='$tel',empr_prof='$prof',empr_categ=$categ,empr_codestat=$emplacement,empr_modif='$updated',empr_sexe=$sexe,empr_date_adhesion='$dateAbonnement',empr_date_expiration='$dateExp' WHERE id_empr=$idEmp";
    if (mysqli_query($connect, $sql)) {
        http_response_code(200);
        echo json_encode("Mis à jour avec succèes");
    } else {
        echo mysqli_error($connect);
    }
} else if (isset($_GET["AddUser"])) {
    $email = $_POST["email"];
    $id = RandomString();
    $nom = $_POST["nom"];
    $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $role = 2;
    $cin = $_POST["cin"];
    $checkEmail = GetNumRows("SELECT * from userAccounts where Email like '$email'");
    $checkCin = GetNumRows("SELECT * from userAccounts where CodeEmpr = '$cin'");
    if ($checkEmail == 1) {
        http_response_code(500);
        echo json_encode(array("msg" => "Email est déjà utilisé !"));
        exit();
    }
    if ($checkCin == 1) {
        http_response_code(500);
        echo json_encode(array("msg" => "Cin est déjà utilisée !"));
        exit();
    }
    $sql = "INSERT INTO userAccounts (idUser,Email,nom,CodeEmpr,mpas,role) values('$id','$email','$nom',$cin,'$pass',$role)";
    if (mysqli_query($connect, $sql)) {
        http_response_code(200);
        echo json_encode("Ajouté avec succées !");
    } else {
        http_response_code(500);
        echo json_encode(array("msg" => "Erreur de serveur !", "error" => mysqli_error($connect)));
    }
} else if (isset($_GET["CheckMail"])) {
    $email = $_POST["email"];
    $check = checkEmail($email);
    if ($check) {
        $code = RandomString($length = 5);
        $user = GetUserByEmail($email);
        $subject = "Recuperation de mot de passe";
        $body = "Bonjour <br><br>
        Vous avez demandé de récupérer votre mot de passe. <br>
        Pour récuperer ce dernier, vous devez saisr ce code au champs requis : <br><br>
        Code : <strong>" . $code . "</strong>
        <br>
        Coridalement,<br>
        Administration du médiathèque régionale de monastir.
         ";
        sendMail($email, $subject, $body);
        http_response_code(200);
        echo json_encode(array("code" => $code));
    } else {
        http_response_code(500);

        echo json_encode(array("msg" => "Aucune inscription est affectuée par cet email !"));
    }
} else if (isset($_GET["ChangePassword"])) {
    $email = $_POST["email"];
    $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $sql = "UPDATE userAccounts SET mpas='$pass' where Email='$email'";
    if (mysqli_query($connect, $sql)) {
        $subject = "changement mot de passe";
        $body = "Bonjour <br><br>
        Vous avez récuperer votre mot de passe avec succès ! 
        <br>
        Date et heure de l'opération : <strong>" . date("Y-m-d H:i") . "</strong><br><br>
        Coridalement,<br>
        Administration du médiathèque régionale de monastir.
         ";
        sendMail($email, $subject, $body);
        http_response_code(200);
        echo json_encode(array("msg" => "Operation Réussite !"));
    } else {
        http_response_code(500);
        echo json_encode(array("msg" => "Opération échouée!", "error" => mysqli_error($connect)));
    }
}
