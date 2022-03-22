<?php
require_once("./utiles.php");
$connect = Connect();
session_start();

if (isset($_GET["register"])) {

    $email = $_POST["email"];
    $code = $_POST["code"];
    $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $exists = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr where empr_cb = '$code'"));
    $codeEx = mysqli_num_rows(mysqli_query($connect, "SELECT * from userAccounts where CodeEmpr = $code "));
    if (!empty($exists)) {
        $id = $exists["id_empr"];
        //print_r( $exists["empr_prenom"]);
        if ($codeEx > 0) {
            echo 2;
        } else {
            $sql = "INSERT INTO userAccounts (idUser,email,CodeEmpr,mpas) values($id,'$email','$code','$pass')";
            if (mysqli_query($connect, $sql)) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        }
    } else
        echo 0;
} else if (isset($_GET["VerifMail"])) {

    $email = $_POST["email"];
    $check = mysqli_num_rows(mysqli_query($connect, "SELECT * from userAccounts where Email = '$email' "));
    if ($check > 0) echo 1;
} else if (isset($_GET["login"])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from userAccounts where Email = '$email' "));
    if (!empty($user)) {
        $mdp = $user["mpas"];
        if (password_verify($pass, $mdp)) {
            $_SESSION["idUser"] = $user["idUser"];
            $_SESSION["email"] = $user["Email"];
            $_SESSION["login"] = true;
            $_SESSION["avatar"] = $user["avatar"];
            $_SESSION["code"] = $user["CodeEmpr"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["mpas"] = $user["mpas"];
            echo 1;
        } else {
            echo 10;
        }
    } else {
        echo 0;
    }
} else if (isset($_GET["Logout"])) {
    session_reset();
    session_destroy();
    header("Location:../main/index.php");
}
