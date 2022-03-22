<?php

require_once("./utiles.php");
$connect = Connect();
if (isset($_GET["edit"])) {
    $notice = $_POST["id_notice"];
    $expl = $_POST["id_expl"];
    $tit1 = mysqli_real_escape_string($connect, $_POST["tit1"]);
    $tit2 =
        mysqli_real_escape_string($connect, $_POST["tit2"]);
    $tit3 =
        mysqli_real_escape_string($connect, $_POST["tit3"]);;
    $tit4 =
        mysqli_real_escape_string($connect, $_POST["tit4"]);;
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
    statut=$statut
     where notice_id=$notice ";
    $sql2 = "UPDATE exemplaires SET expl_typdoc=$type,expl_section=$section,expl_statut=$statut,expl_location=$location where expl_id=$expl";
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
}
