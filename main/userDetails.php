<?php

$current = "details";
require_once("./navigation.php");
if (isset($_GET["idUser"]) && isset($_SESSION["login"]) && $_SESSION["role"] == 1) {
    $emprID = $_GET["idUser"];
    $connect = Connect();
    $data = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr WHERE id_empr = $emprID "));
?>


    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName . $data["empr_prenom"] ?> </title>

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
                                        <strong>Nom&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_nom"] ?>" type="text" id="tit1" placeholder="vide" name="tit1" style="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Prenom&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_prenom"] ?>" type="text" id="tit2" placeholder="vide" name="tit2" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Adresse&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_adr1"] ?>" type="text" id="tit3" placeholder="vide" name="tit3" style="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Code Postal&nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_cp"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Ville</strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_ville"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>
                            <script>

                            </script>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Pays</strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_pays"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Telephone</strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_tel1"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Profession</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_prof"] ?>" type="text" id="" placeholder="vide" name="nbpage" style="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Date d'adhésion</strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_date_adhesion"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Date d'expriation</strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_date_expiration"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_empr" value="<?= $emprID ?>">



                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(243,185,73);">Enregistrer</button></div>
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