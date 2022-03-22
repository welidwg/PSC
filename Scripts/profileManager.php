<?php
require_once("./utiles.php");
$connect = Connect();
session_start();
$id = $_SESSION["idUser"];
$role = $_SESSION["role"];

if (isset($_GET["info"])) {
    $mdp = $_POST["password"];
    $email = $_POST["email"];
    if ($mdp != "") {
        if ($mdp != $_SESSION["mpas"]) {
            $newPass = password_hash($mdp, PASSWORD_BCRYPT);
        } else {
            $newPass = $_SESSION["mpas"];
        }
    } else {
        $newPass = $_SESSION["mpas"];
    }
    if ($role != 1) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $prof = $_POST["prof"];
    }
    if ($email == $_SESSION['email']) {
        if ($role == 1) {
            $nom = $_POST["nom"];

            $r2 = "UPDATE userAccounts SET nom='$nom',mpas='$newPass' where idUser=$id ";
        } else {
            $r2 = "UPDATE userAccounts SET mpas='$newPass' where idUser=$id ";
        }
    } else {
        $checkMail = checkEmail($email);
        if ($checkMail) {
            return "0";
        } else {
            if ($role == 0) {
                $r2 = "UPDATE userAccounts SET mpas='$newPass',Email='$email' where idUser=$id  ";
            } else {
                $nom = $_POST["nom"];

                $r2 = "UPDATE userAccounts SET nom='$nom',mpas='$newPass',Email='$email' where idUser=$id  ";
            }
        }
    }

    if (mysqli_query($connect, $r2)) {
        $_SESSION["email"] = $email;
        $_SESSION["mpas"] = $newPass;
        if ($role == 0) {
            if (mysqli_query($connect, "UPDATE empr SET empr_nom='$nom',empr_prenom='$prenom',empr_prof='$prof' where id_empr=$id")) {
                echo "1";
            } else {
                echo mysqli_error($connect);
            }
        } else {
            echo "1";
        }
    } else {
        echo mysqli_error($connect);
    }
} else if (isset($_GET["contact"])) {
    $address = mysqli_real_escape_string($connect, $_POST["address"]);
    $pays = $_POST["pays"];
    $ville = $_POST["ville"];
    $tel = $_POST["tel"];
    $sql = "UPDATE empr SET empr_adr1='$address',empr_tel1='$tel',empr_ville='$ville',empr_pays='$pays' where id_empr=$id";
    if (mysqli_query($connect, $sql)) {
        echo "1";
    } else {
        echo mysqli_error($connect);
    }
} else if (isset($_GET["avatar"])) {

    $file_name = RandomString() . $_FILES["avatar"]["name"];
    $user = GetUser($id);
    $old = $user["avatar"];
    if ($old != "") {
        unlink("../assets/img/avatars/" . $old);
    }
    if (move_uploaded_file($file_tmp = $_FILES["avatar"]["tmp_name"], "../assets/img/avatars/" . $file_name)) {
        if (mysqli_query($connect, "UPDATE userAccounts SET avatar='$file_name' where idUser=$id")) {
            $_SESSION["avatar"] = $file_name;
            echo "1";
        } else {
            echo mysqli_error($connect);
            unlink("../assets/img/avatars/" . $file_name);
        }
    } else {
        echo "0";
    }
}
