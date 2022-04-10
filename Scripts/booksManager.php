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
    $checkRef = GetNumRows("SELECT * from exemplaires where expl_cb='$ref' and expl_id!=$expl");
    $checkISBN = GetNumRows("SELECT * from notices where code='$isbn' and notice_id!=$notice");
    if ($checkRef > 0) {
        http_response_code(500);
        echo json_encode(array("msg" => "Cette référence est déjà utilisée!"));
        exit();
    }
    if ($checkISBN > 0) {
        http_response_code(500);
        echo json_encode(array("msg" => "Ce ISBN est déjà utilisé!"));
        exit();
    }
    $date_parution = date("Y-m-d", strtotime($_POST["dateParution"]));
    $prix = $_POST["prix"];

    $author = $_POST["auteur"];
    $location = $_POST["location"];
    $type = $_POST["type"];
    $npage = mysqli_real_escape_string($connect, $_POST["nbpage"]);
    $section = $_POST["section"];
    $statut = $_POST["statut"];
    $collection = $_POST["collection"];
    $matiere = mysqli_real_escape_string($connect, $_POST["matiere"]);

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
    prix='$prix',
    coll_id=$collection,
    index_matieres='$matiere'
    where notice_id=$notice ";
    $sql2 = "UPDATE exemplaires SET expl_typdoc=$type,expl_section=$section,expl_statut=$statut,expl_location=$location,expl_cb='$ref' where expl_id=$expl";
    if (mysqli_query($connect, $sql1)) {
        if (mysqli_query($connect, $sql2)) {
            http_response_code(200);
            echo json_encode(array("msg" => "Enregitrée ! "));
            exit();
        } else {
            http_response_code(500);
            echo json_encode(array("msg" => "Erreur de serveur", "error" => mysqli_error($connect)));
            mysqli_rollback($connect);
            exit();
        }
    } else {
        http_response_code(500);
        echo json_encode(array("msg" => "Erreur de serveur", "error" => mysqli_error($connect)));
        exit();
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
} else if (isset($_GET["AddDoc"])) {
    $idnotice = $_POST["notice"];
    $prix = $_POST["prix"];
    $create = date("Y-m-d H:i:s");

    if ($idnotice == "") {
        $isbn = $_POST["isbn"];
        $author = $_POST["auteur"];
        $location = $_POST["location"];
        $date_parution = date("Y-m-d", strtotime($_POST["date_parution"]));
        $collection = $_POST["collection"];
        $taille = $_POST["taille"];
        $matiere = mysqli_real_escape_string($connect, $_POST["matiere"]);
        $year = $_POST["year"];



        $tit1 = mysqli_real_escape_string($connect, $_POST["tit1"]);
        $tit2 =
            mysqli_real_escape_string($connect, $_POST["tit2"]);
        $tit3 =
            mysqli_real_escape_string($connect, $_POST["tit3"]);
        $tit4 =
            mysqli_real_escape_string($connect, $_POST["tit4"]);
        $npage
            = mysqli_real_escape_string($connect, $_POST["npages"]);
        $sql1 = "INSERT INTO notices ( tit1,tit2,tit3,tit4,ed1_id,coll_id,year,code,npages,size,index_matieres,prix,create_date,update_date,date_parution )
         values('$tit1','$tit2','$tit3','$tit4','$author',$collection,'$year','$isbn','$npage','$taille','$matiere','$prix','$create','$create','$date_parution')";

        if (mysqli_query($connect, $sql1)) {
            $idnotice = mysqli_insert_id($connect);
        } else {
            http_response_code(500);
            echo json_encode(array("msg" => "Erreur de serveur !", "error" => mysqli_error($connect)));
            exit();
        }
    }
    $ref = $_POST["ref"];
    $checkRef = GetNumRows("SELECT * from exemplaires where expl_cb='$ref'");
    if ($checkRef > 0) {
        http_response_code(500);
        echo json_encode(array("msg" => "Référence déjà existante !"));
        exit();
    }
    $location = $_POST["location"];
    $cote = $_POST["cote"];
    $type = $_POST["type"];
    $section = $_POST["section"];
    $statut = $_POST["statut"];
    $codestat = $_POST["codestat"];
    $sql2 = "INSERT INTO exemplaires(expl_cb,expl_notice,expl_typdoc,expl_cote,expl_section,expl_statut,expl_location,expl_prix,create_date,update_date,expl_codestat)
     values ('$ref',$idnotice,$type,'$cote',$section,$statut,$location,'$prix','$create','$create',$codestat)";

    if (mysqli_query($connect, $sql2)) {
        http_response_code(200);

        echo json_encode(array("msg" => "Ajout avec succès !"));
    } else {
        http_response_code(500);


        echo json_encode(array("msg" => "Erreur de serveur!", "error" => mysqli_error($connect)));
    }
} else if (isset($_GET["Delete"])) {
    $idnotice = $_POST["idNotice"];
    $idExpl = $_POST["idExpl"];
    $test = $_POST["test"];
    $newFavs = "";
    $users = runQuery("SELECT * from userAccounts where favs like '%$idExpl%'");
    if ($users) {
        foreach ($users as $k => $v) {
            $newFavs = "";
            $favs = explode(",", $users[$k]["favs"]);
            foreach ($favs as $kk => $vv) {

                if ($favs[$kk] == $idExpl) {
                    unset($favs[$kk]);
                }
            }

            foreach ($favs as $kk1 => $vv1) {
                if ($newFavs == "") {
                    $newFavs = $favs[$kk1];
                } else {
                    $newFavs .= "," . $favs[$kk1];
                }
            }

            if (!mysqli_query($connect, "UPDATE userAccounts SET favs = '$newFavs' where idUser='" . $users[$k]["idUser"] . "'")) {
                http_response_code(500);
                echo json_encode(array("msg" => "Erreur de serveur!", "error" => mysqli_error($connect) . "<br>" . $newFavs));
                exit();
            }
        }
    }

    $sql2 = "";
    switch ($test) {
        case 'oui':
            $sql = "DELETE FROM notices where notice_id=$idnotice";
            $sql2 = "DELETE FROM exemplaires where expl_notice=$idnotice";
            $expls = runQuery("SELECT * from exemplaires where expl_notice=$idnotice");
            if ($expls) {
                foreach ($expls as $k1 => $v1) {
                    $users1 = runQuery("SELECT * from userAccounts where favs like '%" . $expls[$k1]["expl_id"] . "%'");
                    if ($users1) {
                        foreach ($users1 as $k => $v) {
                            $newFavs = "";
                            $favs = explode(",", $users1[$k]["favs"]);
                            foreach ($favs as $kk => $vv) {

                                if ($favs[$kk] == $expls[$k1]["expl_id"]) {
                                    unset($favs[$kk]);
                                }
                            }

                            foreach ($favs as $kk1 => $vv1) {
                                if ($newFavs == "") {
                                    $newFavs = $favs[$kk1];
                                } else {
                                    $newFavs .= "," . $favs[$kk1];
                                }
                            }
                            http_response_code(500);


                            
                        if (!mysqli_query($connect, "UPDATE userAccounts SET favs = '$newFavs' where idUser='" . $users1[$k]["idUser"] . "'")) {
                            http_response_code(500);
                            echo json_encode(array("msg" => "Erreur de serveur!", "error" => mysqli_error($connect)));
                            exit();
                            break;
                        }
                        }
                    }
                }
            }
            break;
        case 'non':
            $sql = "DELETE FROM exemplaires where expl_id=$idExpl";
            break;

        default:
            break;
    }
    if (!mysqli_query($connect, $sql)) {
        http_response_code(500);
        echo json_encode(array("msg" => "Erreur de serveur!", "error" => mysqli_error($connect)));

        exit();
    }
    if ($sql2 != "") {
        if (!mysqli_query($connect, $sql2)) {
            http_response_code(500);
            echo json_encode(array("msg" => "Erreur de serveur!", "error" => mysqli_error($connect)));

            exit();
        }
    }
    http_response_code(200);
    echo json_encode(array("msg" => "Supression réussite!"));
}
