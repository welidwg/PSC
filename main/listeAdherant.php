<?php
$current = "biblio";
require_once("./navigation.php");
$connect = Connect();
if (isset($_SESSION["login"]) && ($role == 1 || $role == 2)) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName ?> Liste des adhérants</title>
    </head>

    <body>
        <div class="container-fluid" style="background: rgba(253,126,20,0);padding: 10px;">
            <div class="card shadow mx-auto pulse animated" style="width: 80vw;margin-top: 11px;margin-right: 0px;margin-left: 1px;">
                <div class="card-header py-3" style="background: rgb(249,250,250);">
                    <p style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Liste des Adhérants &nbsp;</strong></p>
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
                                                                                            echo "Code";
                                                                                            # code...
                                                                                            break;
                                                                                        case 2:
                                                                                            echo "Nom";
                                                                                            # code...
                                                                                            break;
                                                                                        case 3:
                                                                                            echo "Ville/Pays";
                                                                                            # code...
                                                                                            break;

                                                                                        default:
                                                                                            # code...
                                                                                            break;
                                                                                    } ?></option>

                                        <?php
                                        } ?>
                                        <?php if (isset($_GET["search"])) {
                                            switch ($_GET["search"]) {
                                                case 1:
                                                    echo '
                                            <option value="2">Nom</option>
                                            <option value="3">Ville/Pays</option>';
                                                    # code...
                                                    break;
                                                case 2:
                                                    echo '
                                            <option value="1">Code</option>
                                            <option value="3">Ville/Pays</option>';
                                                    # code...
                                                    break;
                                                case 3:
                                                    echo '
                                            <option value="1">Code</option>
                                            <option value="2">Nom</option>';
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        } else { ?>
                                            <option value="1">Code</option>
                                            <option value="2">Nom</option>
                                            <option value="3">Ville/Pays</option>
                                        <?php } ?>


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
                                $data = runQuery("SELECT * from empr   WHERE  empr_cb='$val'  order by empr_cb asc Limit $premier,$parPage ");
                                $nbArticles = mysqli_num_rows(
                                    mysqli_query($connect, "SELECT * from empr E,userAccounts U  WHERE E.id_empr=U.idUser  and empr_cb='$val' ")
                                );
                                break;
                            case 2:
                                if (!CheckAr($val)) {
                                    $val = translate($val, "en", "ar");
                                }
                                $data = runQuery("SELECT * from empr   WHERE empr_nom like '%$val%' or empr_prenom like '%$val%'  order by empr_cb asc  Limit $premier,$parPage ");
                                $nbArticles = mysqli_num_rows(
                                    mysqli_query($connect, "SELECT * from empr  WHERE empr_nom like '%$val%' or empr_prenom like '%$val%'")
                                );
                                break;
                            case 3:
                                if (!CheckAr($val)) {
                                    $val = translate($val, "en", "ar");
                                }
                                $data = runQuery("SELECT * from empr   WHERE  empr_ville like '%$val%' or empr_pays like '%$val%' order by empr_cb asc Limit $premier,$parPage");
                                $nbArticles = mysqli_num_rows(
                                    mysqli_query($connect, "SELECT * from empr WHERE empr_ville like '%$val%' or empr_pays like '%$val%'")
                                );
                                break;

                            default:
                                # code...
                                break;
                        }

                        $pages = ceil($nbArticles  / $parPage);
                    } else {
                        $nbArticles = mysqli_num_rows(
                            mysqli_query($connect, "SELECT * from empr   ")
                        );
                        $pages = ceil($nbArticles  / $parPage);
                        $premier = ($currentPage * $parPage) - $parPage;
                        $data = runQuery("SELECT * from empr  order by empr_cb asc Limit $premier,$parPage");
                    }


                    ?>

                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="border-color: rgb(133, 135, 150);">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr style="color: rgb(43,42,41);">
                                    <th style="color: #7a6a5e;">Code d'abonnement</th>
                                    <th style="color: #7a6a5e;">Nom et Prenom</th>
                                    <th style="color: #7a6a5e;">Ville</th>
                                    <th style="color: #7a6a5e;">Sexe</th>
                                    <th style="color: #7a6a5e;">Telephone</th>
                                    <th style="color: #7a6a5e;">Statut</th>
                                    <th style="color: rgb(122,106,94);">Action</th>
                                </tr>
                            </thead>
                            <tbody style="color: rgb(43,42,41);">
                                <?php if (!empty($data)) {
                                    foreach ($data as $kk => $v) {
                                        # code...

                                ?>
                                        <tr>
                                            <td style="color: #7a6a5e;"><?= "#" . $data[$kk]["empr_cb"] ?> </td>
                                            <td style="color: #7a6a5e;"><?= $data[$kk]["empr_prenom"] . " " . $data[$kk]["empr_nom"] ?></td>
                                            <td style="color: #7a6a5e;">
                                                <?= $data[$kk]["empr_pays"] . " | " . $data[$kk]["empr_ville"] ?> </td>
                                            <td><?php
                                                ($data[$kk]["empr_sexe"] == 1) ? print("Homme") : print("Femme");
                                                ?></td>
                                            <td style="color: #7a6a5e;"><?= $data[$kk]["empr_tel1"] ?></td>

                                            <td style="color: #7a6a5e;"><?= $data[$kk]["empr_prof"] ?></td>
                                            <td>
                                                <a class="bg-transparent text-warning" target="_blank" href="./userDetails.php?idUser=<?= $data[$kk]["id_empr"] ?>"><i class="fa fa-eye"></i></a>
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
                                    <td style="color: #7a6a5e;"><strong>Code d'abonnement</strong></td>
                                    <td><strong style="color: #7a6a5e;">Nom et Prenom</strong></td>
                                    <td><strong style="color: #7a6a5e;">Ville</strong></td>
                                    <td><strong style="color: #7a6a5e;">Sexe</strong></td>
                                    <td><strong style="color: #7a6a5e;">Téléphone</strong></td>
                                    <td><strong style="color: #7a6a5e;">Statut</strong></td>
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
<?php } else { ?>
    <script>
        ReloadIndex()
    </script>

<?php
} ?>