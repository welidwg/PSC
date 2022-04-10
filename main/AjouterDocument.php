<?php
$current = "addDoc";
require_once("./navigation.php");
if (isset($_GET["isbn"])) {
    $isbn = $_GET["isbn"];
    if ($isbn != "NULL") {
        $check = GetNumRows("SELECT * from notices where code='$isbn'");
    } else {
        $check = 0;
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName ?> Ajouter un Document</title>
    </head>

    <body>

        <div class="container-fluid" style="padding: 100px;">


            <div class="row mb-3">

                <div class="col-lg-12">


                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3" style="background: #f7f6f6;">
                                    <p style="color: rgb(236,155,33);font-family: Amiri, serif;font-size: 18px;text-align: center;"><strong>Ajouter un document </strong></p>
                                </div>
                                <div class="card-body">
                                    <script>
                                        $(function() {
                                            $("#add").on("submit", function(e) {
                                                e.preventDefault()
                                                $.ajax({
                                                    type: "post",
                                                    url: "../Scripts/booksManager.php?AddDoc",
                                                    data: $("#add").serialize(),
                                                    dataType: "json",
                                                    success: function(res) {
                                                        alertify.success(res.msg);
                                                        setTimeout(() => {
                                                            window.location.reload();
                                                        }, 700);
                                                    },
                                                    error: (e) => {
                                                        alertify.error(e.responseJSON.msg);
                                                        console.log(e.responseJSON.error);
                                                    }
                                                });
                                            });

                                        });
                                    </script>
                                    <?php if ($check > 0) {
                                        $notice = GetNoticeByISBN($isbn);
                                        $idnotice = $notice["notice_id"];
                                    ?>

                                    <?php } else {
                                        $notice = "";
                                        $idnotice = "";
                                    } ?>

                                    <form id="add">
                                        <input type="hidden" name="notice" value="<?= $idnotice ?>">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>ISBN / Identifiant unique</strong>
                                                        <br></label>
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> required value="<?php ($check > 0) ? print($notice["code"]) : print($_GET["isbn"]) ?>" class="form-control" type="text" id="" placeholder="ISBN/Identifiant unique" name="isbn">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                <strong>Titres</strong>
                                                <br></label>
                                            <div class="col">
                                                <div class="mb-3">

                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> value="<?php ($notice != "" && $notice["tit1"] != "") ? print($notice["tit1"]) : "" ?>" class="form-control" type="text" id="" placeholder="Titre 1" name="tit1">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> value="<?php ($notice != "" && $notice["tit2"] != "") ? print($notice["tit2"]) : "" ?>" class="form-control" type="text" id="" placeholder="Titre 2" name="tit2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col">
                                                <div class="mb-3">

                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> value="<?php ($notice != "" && $notice["tit3"] != "") ? print($notice["tit3"]) : "" ?>" class="form-control" type="text" id="" placeholder="Titre 3" name="tit3">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> value="<?php ($notice != "" && $notice["tit4"] != "") ? print($notice["tit4"]) : "" ?>" class="form-control" type="text" id="" placeholder="Titre 4" name="tit4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Auteur</strong>
                                                        <br></label>
                                                    <?php if ($notice != "") {
                                                        if ($notice["ed1_id"] != 0) {


                                                            $author = GetAuthorById($notice["ed1_id"]);
                                                    ?>
                                                            <input class="form-control" type="text" name="" value="<?= $author["author_name"] . " " . $author["author_rejete"] ?>" disabled id="">

                                                        <?php

                                                        } else {
                                                        ?>
                                                            <input class="form-control" type="text" name="" value="inconnue" disabled id="">

                                                        <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <select class="form-control" data-show-subtext="true" data-live-search="true" name="auteur" id="auteur">
                                                            <?php if ($check == 0) { ?>
                                                                <option value="1">Aucun</option>
                                                            <?php } ?>


                                                            <?php
                                                            $author = runQuery("SELECT * from authors");
                                                            foreach ($author as $kk1 => $value1) {
                                                            ?>
                                                                <option value="<?= $author[$kk1]["author_id"] ?>"><?= $author[$kk1]["author_name"] . " " . $author[$kk1]["author_rejete"] ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <script>
                                                            $(function() {
                                                                $("#auteur").select2({
                                                                    theme: "bootstrap4"
                                                                })
                                                            });
                                                        </script>
                                                    <?php


                                                    } ?>


                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Collection</strong>
                                                        <br></label>
                                                    <?php if ($notice != "") {

                                                        if ($notice["coll_id"] != 0) {
                                                        }
                                                        $coll = GetCollectionById($notice["coll_id"]);
                                                    ?>
                                                        <input class="form-control" type="text" name="" value="<?= ($notice["coll_id"] != 0) ? print($coll["collection_name"]) : "Aucune Collection" ?>" disabled id="">

                                                    <?php

                                                    } else {
                                                    ?>

                                                        <select class="form-control" data-show-subtext="true" data-live-search="true" name="collection" id="collection">
                                                            <?php if (($check == 0)) { ?>
                                                                <option value="0">Aucune</option>
                                                            <?php } ?>

                                                            <?php
                                                            $author = runQuery("SELECT * from collections");
                                                            foreach ($author as $kk1 => $value1) {
                                                            ?>
                                                                <option value="<?= $author[$kk1]["collection_id"] ?>"><?= $author[$kk1]["collection_name"] ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <script>
                                                            $(function() {
                                                                $("#collection").select2({
                                                                    theme: "bootstrap4"
                                                                })
                                                            });
                                                        </script>
                                                    <?php


                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Année</strong>
                                                        <br></label>
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> required value="<?php ($check > 0) ? print($notice["year"]) : "" ?>" class="form-control" type="number" min="1940" max="2022" id="" placeholder="année" name="year">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Nombre des pages</strong>
                                                        <br></label>

                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> required value="<?php ($check > 0) ? print($notice["npages"]) : "" ?>" class="form-control" type="text" id="" placeholder="Nombre des pages" name="npages">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Taille</strong>
                                                        <br></label>
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> value="<?php ($check > 0) ? print($notice["size"]) : "" ?>" class="form-control" type="text" id="" placeholder="taille" name="taille">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Prix</strong>
                                                        <br></label>
                                                    <input required value="<?php ($check > 0) ? print($notice["prix"]) : "" ?>" class="form-control" type="text" id="" placeholder="prix" name="prix">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Matière</strong>
                                                        <br></label>
                                                    <?php if ($check > 0) {
                                                    ?>
                                                        <input disabled required value="<?php ($notice["index_matieres"] == "") ? print("Aucune matiere") : print($notice["index_matieres"]) ?>" class="form-control" type="text" id="" placeholder="matiere" name="matiere">

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <select class="form-control" data-show-subtext="true" data-live-search="true" name="matiere" id="matiere">
                                                            <?php if ($check == 0) { ?>
                                                                <option value="0">Aucune</option>
                                                            <?php } ?>

                                                            <?php
                                                            $mat = runQuery("SELECT Distinct (index_matieres) from notices where index_matieres!=''");
                                                            foreach ($mat as $kk2 => $value2) {
                                                            ?>
                                                                <option value="<?= $mat[$kk2]["index_matieres"] ?>"><?= $mat[$kk2]["index_matieres"] ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                        <script>
                                                            $(function() {
                                                                $("#matiere").select2({
                                                                    theme: "bootstrap4"
                                                                })
                                                            });
                                                        </script>
                                                    <?php
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Date de parution</strong>
                                                        <br></label>
                                                    <input <?php ($check > 0) ? print("disabled") : "" ?> required value="<?php ($check > 0) ? print($notice["date_parution"]) : "" ?>" class="form-control" type="date" id="" placeholder="Date de parution" name="date_parution">
                                                </div>
                                            </div>
                                        </div>
                                        <!--Debut exp-->
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Référence d'exemplaire</strong>
                                                        <br></label>
                                                    <input required class="form-control" type="number" id="" placeholder="référence" name="ref">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Type d'exemplaire</strong>
                                                        <br></label>
                                                    <select name="type" id="type" class="form-control">
                                                        <?php if ($idnotice != "") {
                                                            $connect = Connect();
                                                            $tp = mysqli_fetch_array(mysqli_query($connect, "SELECT * from exemplaires E,docs_type D where expl_notice=$idnotice and E.expl_typdoc = D.idtyp_doc Limit 1"));
                                                        } else {
                                                            $tp = "";
                                                        } ?>

                                                        <?php if ($tp != "") {
                                                        ?>
                                                            <option value="<?= $tp["idtyp_doc"] ?>"><?= $tp["tdoc_libelle"] ?></option>
                                                        <?php } else {
                                                        ?>



                                                            <?php
                                                            $type = runQuery("SELECT * from docs_type ");
                                                            foreach ($type as $kk5 => $value5) {
                                                            ?>
                                                                <option value="<?= $type[$kk5]["idtyp_doc"] ?>"><?= $type[$kk5]["tdoc_libelle"] ?></option>
                                                            <?php
                                                            } ?>
                                                        <?php
                                                        } ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Cote d'exemplaire</strong>
                                                        <br></label>
                                                    <?php if ($idnotice != "") {
                                                        $connect = Connect();
                                                        $cote = mysqli_fetch_array(mysqli_query($connect, "SELECT expl_cote from exemplaires where expl_notice=$idnotice Limit 1"));
                                                    } else {
                                                        $cote = "";
                                                    } ?>
                                                    <input <?= ($cote != "") ? print("value='" . $cote[0] . "' readonly ") : "" ?> required class="form-control" type="text" id="" placeholder="exp:210.9 DJA" name="cote">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Section d'exemplaire</strong>
                                                        <br></label>
                                                    <select class="form-control" name="section" id="section">


                                                        <?php
                                                        $section = runQuery("SELECT * from docs_section ");
                                                        foreach ($section as $kk3 => $value3) {
                                                        ?>
                                                            <option value="<?= $section[$kk3]["idsection"] ?>"><?= $section[$kk3]["section_libelle"] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Statut d'exemplaire</strong>
                                                        <br></label>
                                                    <select class="form-control" name="statut" id="statut">

                                                        <?php
                                                        $statut = runQuery("SELECT * from docs_statut ");
                                                        foreach ($statut as $kk4 => $value4) {
                                                        ?>
                                                            <option value="<?= $statut[$kk4]["idstatut"] ?>"><?= $statut[$kk4]["statut_libelle"] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                                        <strong>Location</strong>
                                                    </label>
                                                    <select class="form-control" data-show-subtext="true" data-live-search="true" name="location" id="location">


                                                        <?php
                                                        $loc = runQuery("SELECT * from docs_location");
                                                        foreach ($loc as $kk => $value) {
                                                        ?>
                                                            <option data-token="<?= $loc[$kk]["idlocation"] ?>" value="<?= $loc[$kk]["idlocation"] ?>"><?= $loc[$kk]["location_libelle"] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                    <script>
                                                        $('#location').select2({
                                                            theme: "bootstrap4"
                                                        })
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                        <strong>Categorie</strong>
                                                        <br></label>
                                                    <select class="form-control" name="codestat" id="codestat">

                                                        <?php
                                                        $stat = runQuery("SELECT * from docs_codestat ");
                                                        foreach ($stat as $kk4 => $value4) {
                                                        ?>
                                                            <option value="<?= $stat[$kk4]["idcode"] ?>"><?= $stat[$kk4]["codestat_libelle"] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(241,183,72);font-size: 16px;font-family: Amiri, serif;border-color: rgb(241,183,72);">Ajouter</button></div>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>


        <?php require_once("./footer.php"); ?>

        </div>

    </body>

    </html>
<?php } else {
?>
    <script>
        ReloadIndex();
    </script>
<?php } ?>