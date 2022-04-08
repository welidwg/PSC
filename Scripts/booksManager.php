<?php

require_once("./utiles.php");
$connect = Connect();
session_start();
if (isset($_GET["edit"])) {
    $notice = $_POST["id_notice"];
    $expl = $_POST["id_expl"];
    $tit1 = mysqli_real_escape_string($connect, $_POST["tit1"]);
    $tit2 =
        mysqli_real_escape_string($connect, $_POST["tit2"]);
    $tit3 =
        mysqli_real_escape_string($connect, $_POST["tit3"]);
    $tit4 =
        mysqli_real_escape_string($connect, $_POST["tit4"]);
    $isbn = $_POST["isbn"];
    $ref = $_POST["ref"];
    $date_parution = date("Y-m-d", strtotime($_POST["dateParution"]));
    $prix = $_POST["prix"];

    $author = $_POST["auteur"];
    $location = $_POST["location"];
    $type = $_POST["type"];
    $npage = mysqli_real_escape_string($connect, $_POST["nbpage"]);
    $section = $_POST["section"];
    $statut = $_POST["statut"];
    $sql1 = "UPDATE notices SET
    tit1='$tit1',
    tit2='$tit2',
    tit3='$tit3',
    tit4='$tit4',
    ed1_id=$author,
    npages='$npage',
    statut=$statut,
    code='$isbn',
    date_parution='$date_parution',
    prix='$prix'
     where notice_id=$notice ";
    $sql2 = "UPDATE exemplaires SET expl_typdoc=$type,expl_section=$section,expl_statut=$statut,expl_location=$location,expl_cb='$ref' where expl_id=$expl";
    if (mysqli_query($connect, $sql1)) {
        if (mysqli_query($connect, $sql2)) {
            echo "1";
        } else {
            mysqli_rollback($connect);
            echo mysqli_error($connect);
        }
    } else {
        echo mysqli_error($connect);
    }
    //echo $npage;
} else if (isset($_GET["Fav"])) {
    $expl_id = $_POST["expl_id"];
    $exemplaire = mysqli_fetch_array(mysqli_query($connect, "SELECT * from exemplaires where expl_id = $expl_id"));
    $idUser = $_SESSION["idUser"];
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from userAccounts where idUser = '$idUser'"));
    $fav = "";
    if ($user["favs"] == "") {
        $fav = $expl_id;
        $action = "1";
    } else {
        $test = explode(",", $user["favs"]);

        if (count($test) == 1) {
            if ($test[0] == $expl_id) {
                $fav = "";
                $action = "0";
            } else {
                $fav = $test[0] . "," . $expl_id;
                $action = "1";
            }
        } else {
            if (in_array($expl_id, $test)) {
                foreach ($test as $k => $v) {
                    if ($test[$k] == $expl_id) {
                        unset($test[$k]);
                    }
                }
                foreach ($test as $kk => $vv) {
                    if ($fav == "") {
                        $fav = $test[$kk];
                    } else {
                        $fav .= "," . $test[$kk];
                    }
                }
                $action = "0";
            } else {
                $fav = $user["favs"] . "," . $expl_id;
                $action = "1";
            }
        }
    }

    if (mysqli_query($connect, "UPDATE userAccounts SET favs='$fav' where idUser='$idUser'")) {
        echo $action;
    } else {
        echo mysqli_error($connect);
    }
}
