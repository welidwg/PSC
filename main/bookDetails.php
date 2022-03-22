<?php

$current = "details";
require_once("./navigation.php");
if (isset($_GET["explID"]) && isset($_GET["noticeID"])) {
    $expl = $_GET["explID"];
    $notice = $_GET["noticeID"];
    $connect = Connect();
    $data = mysqli_fetch_array(mysqli_query($connect, "SELECT * from notices N , exemplaires E,docs_location D,authors A , docs_type T,docs_section S,docs_statut DS WHERE N.notice_id=$notice and E.expl_id=$expl and N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and T.idtyp_doc=E.expl_typdoc and E.expl_section=S.idsection and N.statut=DS.idstatut "));
    if (!isset($_SESSION["login"])) {
        $role = "";
    }
?>


    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName ?> Détails de livre</title>
       
        <style>
            input {
                color: black;
            }
        </style>
    </head>



    <body>
        <div class="col" style="width: 75vw;margin: 34px;">
            <div class="card shadow mx-auto mb-3" style="width: 100%;">
                <div class="card-header py-3" style="background: #f7f6f6;">
                    <p style="color: rgb(231,151,32);font-family: Amiri, serif;font-size: 18px;text-align: center;"><strong>Informations générales :</strong></p>
                </div>
                <div class="card-body">
                    <div style="text-align:center;"></div>
                    <form id="edit">
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="username" style="color: rgb(121,105,93);">
                                        <strong>Titre 1&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["tit1"] ?>" type="text" id="tit1" placeholder="vide" name="tit1" style="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Titre 2&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["tit2"] ?>" type="text" id="tit2" placeholder="vide" name="tit2" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Titre 3&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["tit3"] ?>" type="text" id="tit3" placeholder="vide" name="tit3" style="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Titre 4&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["tit4"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Auteur</strong>
                                    </label>
                                    <select class="form-control" data-show-subtext="true" data-live-search="true" name="auteur" id="auteur">
                                        <?php

                                        $auth_id = $data["author_id"];

                                        ?>
                                        <option value="<?= $auth_id ?>"><?= $data["author_name"] . " " . $data["author_rejete"] ?></option>

                                        <?php
                                        $author = runQuery("SELECT * from authors where author_id!=$auth_id");
                                        foreach ($author as $kk1 => $value1) {
                                        ?>
                                            <option value="<?= $author[$kk1]["author_id"] ?>"><?= $author[$kk1]["author_name"] . " " . $author[$kk1]["author_rejete"] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <script>
                                $(function() {
                                    $('#auteur').select2();
                                    $('#location').select2();


                                });
                            </script>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Location</strong>
                                    </label>
                                    <select class="form-control" data-show-subtext="true" data-live-search="true" name="location" id="location">
                                        <?php
                                        $l = $data["location_libelle"];
                                        $l_id = $data["idlocation"];

                                        ?>
                                        <option value="<?= $l_id ?>"><?= $l ?></option>

                                        <?php
                                        $loc = runQuery("SELECT * from docs_location where location_libelle!='$l'");
                                        foreach ($loc as $kk => $value) {
                                        ?>
                                            <option data-token="<?= $loc[$kk]["idlocation"] ?>" value="<?= $loc[$kk]["idlocation"] ?>"><?= $loc[$kk]["location_libelle"] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Type de document</strong>
                                    </label>
                                    <select class="form-control" data-show-subtext="true" data-live-search="true" name="type" id="type">
                                        <?php

                                        $type_id = $data["idtyp_doc"];

                                        ?>
                                        <option value="<?= $type_id ?>"><?= $data["tdoc_libelle"]  ?></option>

                                        <?php
                                        $type = runQuery("SELECT * from docs_type where idtyp_doc!=$type_id");
                                        foreach ($type as $kk2 => $value2) {
                                        ?>
                                            <option value="<?= $type[$kk2]["idtyp_doc"] ?>"><?= $type[$kk2]["tdoc_libelle"] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Nombre des pages</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["npages"] ?>" type="text" id="" placeholder="vide" name="nbpage" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Section</strong>
                                    </label>
                                    <select class="form-control" name="section" id="section">
                                        <?php

                                        $section_id = $data["expl_section"];

                                        ?>
                                        <option value="<?= $section_id ?>"><?= $data["section_libelle"] ?></option>

                                        <?php
                                        $section = runQuery("SELECT * from docs_section where idsection!=$section_id");
                                        foreach ($section as $kk3 => $value3) {
                                        ?>
                                            <option value="<?= $section[$kk3]["idsection"] ?>"><?= $section[$kk3]["section_libelle"] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Statut de document</strong>
                                    </label>
                                    <select class="form-control" name="statut" id="statut">
                                        <?php

                                        $statut_id = $data["expl_statut"];

                                        ?>
                                        <option value="<?= $statut_id ?>"><?= $data["statut_libelle"] ?></option>

                                        <?php
                                        $statut = runQuery("SELECT * from docs_statut where idstatut!=$statut_id");
                                        foreach ($statut as $kk4 => $value4) {
                                        ?>
                                            <option value="<?= $statut[$kk4]["idstatut"] ?>"><?= $statut[$kk4]["statut_libelle"] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_notice" value="<?= $notice ?>">
                        <input type="hidden" name="id_expl" value="<?= $expl ?>">



                        <?php if ($role == 1) : ?>
                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(243,185,73);">Enregistrer</button></div>
                        <?php endif; ?>
                    </form>
                    <script>
                        $(function() {

                            $("#edit").on("submit", (e) => {
                                e.preventDefault()
                                let form = $(this);
                                $.ajax({
                                    type: "post",
                                    url: "../Scripts/booksManager.php?edit",
                                    data: $("#edit").serialize(),
                                    success: function(res) {
                                        if (res == 1) {
                                            alertify.success("Enregistrée !");
                                            setTimeout(() => {
                                                window.location.reload()
                                            }, 700);
                                        } else {
                                            alertify.error("Erreur de serveur ! ");
                                            console.log(res);
                                        }

                                    }
                                });
                            })

                        });
                    </script>
                </div>
            </div>
        </div>

        <script>
            let role = "<?= $role ?>"

            $(":input,select").prop("disabled", false)

            if (role == 0) {
                $(":input,select").prop("disabled", true)
                console.log(role);

            }
        </script>

        </div>

        </div>

    <?php
    require_once("./footer.php");
} else {
    ?>
        <script>
            ReloadIndex()
        </script>
    <?php
} ?>
    </body>

    </html>