<?php
$current = "biblio";
require_once("./navigation.php");
$connect = Connect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Bibliothèque</title>
</head>

<body>
    <div class="container-fluid" style="background: rgba(253,126,20,0);padding: 10px;">
        <div class="card shadow mx-auto pulse animated" style="width: 80vw;margin-top: 11px;margin-right: 0px;margin-left: 1px;">
            <div class="card-header py-3" style="background: rgb(249,250,250);">
                <p style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Bibliothèque&nbsp;</strong></p>
            </div>
            <div class="card-body" style="background: #f9fafa;">
                <div class="row">

                    <div class="col-md-12 col-lg-9 mx-auto" style="height: 59px;">

                        <form method="get" class="d-flex user">
                            <label for="search" class="" style="width: 110px;">Filtrer par </label>

                            <div class="dropdown " style="width: 10vw;">
                                <select id="search" class="form-control w-100" style="background-color: #f2b849;color:white" name="search" id="">
                                    <?php if (isset($_GET["search"])) {
                                    ?>
                                        <option value="<?= $_GET["search"] ?>"><?php switch ($_GET["search"]) {
                                                                                    case 1:
                                                                                        echo "Titre";
                                                                                        # code...
                                                                                        break;
                                                                                    case 2:
                                                                                        echo "Auteur";
                                                                                        # code...
                                                                                        break;
                                                                                    case 3:
                                                                                        echo "Référence";
                                                                                        # code...
                                                                                        break;
                                                                                    case 4:
                                                                                        echo "Location";
                                                                                        # code...
                                                                                        break;
                                                                                    case 5:
                                                                                        echo "Type";
                                                                                        # code...
                                                                                        break;
                                                                                    default:
                                                                                        # code...
                                                                                        break;
                                                                                } ?></option>

                                    <?php
                                    } ?>
                                    <?php if (isset($_GET['search'])) {
                                        switch ($_GET['search']) {
                                            case '1':
                                                echo ' <option value="2">Auteur</option>
                                        <option value="3">Référence</option>
                                        <option value="4">Location</option>
                                        <option value="5">Type</option>';
                                                # code...
                                                break;
                                            case '2':
                                                echo '
                                        <option value="1">Titre</option>
                                        <option value="3">Référence</option>
                                        <option value="4">Location</option>
                                        <option value="5">Type</option>';
                                                break;
                                            case '3':
                                                echo '
                                        <option value="1">Titre</option>
                                        <option value="2">Auteur</option>
                                        <option value="4">Location</option>
                                        <option value="5">Type</option>';
                                                break;
                                            case '4':
                                                echo '
                                        <option value="1">Titre</option>
                                        <option value="2">Auteur</option>
                                        <option value="3">Référence</option>
                                        <option value="5">Type</option>';
                                                break;
                                            case '5':
                                                echo '
                                        <option value="1">Titre</option>
                                        <option value="2">Auteur</option>
                                        <option value="3">Référence</option>
                                        <option value="4">Location</option>';
                                                break;
                                            default:
                                                # code...
                                                break;
                                        }
                                    } else {
                                    ?>
                                        <option value="1">Titre</option>
                                        <option value="2">Auteur</option>
                                        <option value="3">Référence</option>
                                        <option value="4">Location</option>
                                        <option value="5">Type</option>
                                    <?php
                                    } ?>

                                </select>
                            </div>
                            <div class="text-md-end w-100 dataTables_filter" id="dataTable_filter"><input minlength="3" required name="q" value="<?php if (isset($_GET["q"])) {
                                                                                                                                                        echo $_GET["q"];
                                                                                                                                                    } ?>" class="shadow form-control form-control-sm" type="search" aria-controls="dataTable" placeholder="Recherche..." style="padding: 6px 12px;height: 38px;"><label class="form-label"></label></div>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $currentPage = (int) strip_tags($_GET['page']);
                } else {
                    $currentPage = 1;
                }
                $parPage  = 10;


                if (isset($_GET["q"])) {
                    $val = $_GET["q"];
                    $premier = ($currentPage * $parPage) - $parPage;

                    switch ($_GET["search"]) {
                        case 1:
                            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A,docs_section S  WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and E.expl_section=S.idsection and  (tit1 like '%$val%' or tit2 like '%$val%' or tit3 like '%$val%' or tit4 like '%$val%')  Limit $premier,$parPage ");
                            $nbArticles = mysqli_num_rows(
                                mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A,docs_section S  WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and E.expl_section=S.idsection and  (tit1 like '%$val%' or tit2 like '%$val%' or tit3 like '%$val%' or tit4 like '%$val%')")
                            );
                            break;
                        case 2:
                            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A,docs_section S  WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and E.expl_section=S.idsection and  (author_name like '%$val%' or author_rejete like '%$val%' )  Limit $premier,$parPage ");
                            $nbArticles = mysqli_num_rows(
                                mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A,docs_section S  WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and E.expl_section=S.idsection and  (author_name like '%$val%' or author_rejete like '%$val%' )   ")
                            );
                            break;
                        case 3:
                            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A ,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id  and E.expl_section=S.idsection and expl_cb = '$val'   Limit $premier,$parPage ");
                            $nbArticles = mysqli_num_rows(
                                mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A ,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id  and E.expl_section=S.idsection and expl_cb = '$val'  ")
                            );
                            break;
                        case 4:
                            if (!CheckAr($val)) {
                                $val = translate($val, "fr", "ar");
                            }


                            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A ,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id  and E.expl_section=S.idsection and D.location_libelle like '%$val%'   Limit $premier,$parPage ");
                            $nbArticles = mysqli_num_rows(
                                mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A ,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id  and E.expl_section=S.idsection and D.location_libelle like '%$val%' ")
                            );

                            break;
                        case 5:
                            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A , docs_type T,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and T.idtyp_doc=E.expl_typdoc and E.expl_section=S.idsection  and tdoc_libelle like '%$val%' Limit $premier,$parPage ");
                            $nbArticles = mysqli_num_rows(
                                mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A , docs_type T,docs_section S WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and T.idtyp_doc=E.expl_typdoc and E.expl_section=S.idsection  and tdoc_libelle like '%$val%' ")
                            );
                            break;
                        default:
                            # code...
                            break;
                    }

                    $pages = ceil($nbArticles  / $parPage);
                } else {
                    $nbArticles = 0;
                    $pages = 0;
                    $premier = 0;
                    $data = [];
                }



                ?>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="border-color: rgb(133, 135, 150);">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr style="color: rgb(43,42,41);">
                                <th style="color: #7a6a5e;">Reference</th>
                                <th style="color: #7a6a5e;">Titres de livre</th>
                                <th style="color: #7a6a5e;">Auteur</th>
                                <th style="color: #7a6a5e;">Location</th>
                                <th style="color: #7a6a5e;">categorie</th>
                                <th style="color: #7a6a5e;">section</th>
                                <th style="color: rgb(122,106,94);">Action</th>
                            </tr>
                        </thead>
                        <tbody style="color: rgb(43,42,41);">
                            <?php if (!empty($data)) {
                                $class = "far fa-bookmark";
                                $i = 0;
                                foreach ($data as $k => $v) {
                                    $i++;
                                    $class = "far fa-bookmark";
                                    if (isset($_SESSION["login"])) {
                                        $user = GetUser($_SESSION["idUser"]);

                                        if ($user["favs"] == "") {
                                            $class = "far fa-bookmark";
                                        } else {
                                            $favs = explode(",", $user["favs"]);
                                            if (count($favs) == 1) {
                                                if ($favs[0] == $data[$k]["expl_id"]) {
                                                    $class = "fas fa-bookmark";
                                                }
                                            } else {
                                                foreach ($favs as $kk => $vv) {
                                                    if ($favs[$kk] == $data[$k]["expl_id"]) {
                                                        $class = "fas fa-bookmark";
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    # code...

                            ?>
                                    <tr>
                                        <td style="color: #7a6a5e;"><?= "#" . $data[$k]["expl_cb"] ?> </td>
                                        <td style="color: #7a6a5e;"><?php
                                                                    ($data[$k]["tit1"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data[$k]["tit1"]) . "<br>" : print("");
                                                                    ($data[$k]["tit2"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data[$k]["tit2"]) . "<br>" : print("");
                                                                    ($data[$k]["tit3"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data[$k]["tit3"]) . "<br>" : print("");
                                                                    ($data[$k]["tit4"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data[$k]["tit4"]) . "<br>" : print("");
                                                                    ?></td>
                                        <td style="color: #7a6a5e;"><?= $data[$k]["author_rejete"] . " " . $data[$k]["author_name"]  ?></td>
                                        <td><?= $data[$k]["location_libelle"] ?></td>
                                        <td style="color: #7a6a5e;"><?= $data[$k]["index_l"] ?></td>
                                        <td style="color: #7a6a5e;"><?= $data[$k]["section_libelle"] ?></td>
                                        <td class="d-flex" style="justify-content: space-between;border:unset">
                                            <a target="_blank" class="text-dark bg-transparent " style="border:none" href="./bookDetails.php?explID=<?= $data[$k]["expl_id"] ?>&noticeID=<?= $data[$k]["notice_id"] ?>"><i class="fa fa-eye"></i></a>
                                            <?php if (isset($_SESSION["login"])) {

                                            ?>
                                                <form id="fav<?= $i ?>">
                                                    <input type="hidden" id="expl_id<?= $i ?>" name="expl_id<?= $i ?>" value="<?= $data[$k]["expl_id"] ?>">

                                                    <button type="submit" class=" bg-transparent text-danger border-0"><i id="icon<?= $i ?>" class="<?= $class ?>"></i></button>
                                                </form>
                                            <?php } ?>
                                            <script>
                                                $(function() {
                                                    $("#fav<?= $i ?>").on("submit", (e) => {
                                                        e.preventDefault();
                                                        let expl_id = $("#expl_id<?= $i ?>").val();
                                                        $.ajax({
                                                            type: "post",
                                                            url: "../Scripts/booksManager.php?Fav",
                                                            data: {
                                                                expl_id: expl_id
                                                            },
                                                            success: function(res) {
                                                                $("#icon<?= $i ?>").removeAttr("class");

                                                                if (res == 1) {
                                                                    $("#icon<?= $i ?>").addClass("fas fa-bookmark")
                                                                } else {
                                                                    $("#icon<?= $i ?>").addClass("far fa-bookmark")

                                                                }
                                                                console.log(res);
                                                            },
                                                            error: (e) => {
                                                                console.log(e.responseText);
                                                                alertify.error("Erreur de serveur .. ")
                                                            }
                                                        });
                                                    })
                                                });
                                            </script>

                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td>Aucune Resultat</td>
                                </tr>

                            <?php
                            } ?>
                        </tbody>
                        <tfoot style="color: rgb(43,42,41);">
                            <tr>
                                <td style="color: #7a6a5e;"><strong>Reference</strong></td>
                                <td><strong style="color: #7a6a5e;">Titres de livre</strong></td>
                                <td><strong style="color: #7a6a5e;">Auteur</strong></td>
                                <td><strong style="color: #7a6a5e;">Location</strong></td>
                                <td><strong style="color: #7a6a5e;">Categorie</strong></td>
                                <td><strong style="color: #7a6a5e;">Section</strong></td>
                                <td style="color: rgb(122,106,94);"><strong>Action</strong><br></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <style>
                    .pag {
                        width: 50vw;
                        max-width: 50vw;
                        position: relative;
                        overflow: auto;
                    }
                </style>
                <div class="row">

                    <div class="col-md-5">
                        <nav class="">
                            <ul class="pagination pag">

                                <?php for ($page = 1; $page <= $pages; $page++) : ?>

                                    <li class="page-item <?php ($currentPage == $page) ? print("active") : "" ?>"><a class="page-link" href="<?php if (isset($_GET["q"])) {
                                                                                                                                                    if (isset($_GET["search"])) {
                                                                                                                                                        echo "?search=" . $_GET["search"] . "&q=" . $_GET["q"] . "&page=$page";
                                                                                                                                                    } else {
                                                                                                                                                        echo "?q=" . $_GET["q"] . "&page=$page";
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    echo "?page=$page";
                                                                                                                                                } ?>"><?php echo $page ?></a></li>
                                <?php endfor ?>


                            </ul>
                        </nav>

                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?php ($currentPage == 1) ? print("disabled") : "" ?>"><a class="page-link" href=" <?php
                                                                                                                                    if (isset($_GET["q"])) {
                                                                                                                                        echo "?page=" . ($currentPage - 1) . "&search=" . $_GET["search"] . "&q=" . $_GET["q"];
                                                                                                                                    } else {
                                                                                                                                        echo "?page=" . ($currentPage - 1);
                                                                                                                                    }
                                                                                                                                    ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>

                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <li class="page-item <?php ($currentPage == $pages) ? print("disabled") : "" ?>"><a class="page-link" href="<?php
                                                                                                                                        if (isset($_GET["q"])) {
                                                                                                                                            echo "?page=" . ($currentPage + 1) . "&search=" . $_GET["search"] . "&q=" . $_GET["q"];
                                                                                                                                        } else {
                                                                                                                                            echo "?page=" . ($currentPage + 1);
                                                                                                                                        }
                                                                                                                                        ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <?php



    require_once("./footer.php"); ?>

    </div>

</body>

</html>