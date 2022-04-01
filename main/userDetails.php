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
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="username" style="color: rgb(121,105,93);">
                                        <strong>Code d'abonnement <i class="fas fa-lock"></i> &nbsp;</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_cb"] ?>" type="text" id="code" placeholder="vide" name="code" style="" disabled="true">
                                </div>
                            </div>

                        </div>
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
                                    <select name="ville" id="ville" class="form-control">
                                        <option value="<?= $data["empr_ville"] ?>"><?= $data["empr_ville"] ?></option>
                                        <?php

                                        $vl = runQuery("SELECT DISTINCT(empr_ville) from empr where empr_ville!='" . $data["empr_ville"] . "' and empr_ville not like ''  order by empr_ville asc ");
                                        foreach ($vl as $k1 => $v1) {
                                        ?>
                                            <option value="<?= $vl[$k1]["empr_ville"] ?>"><?= $vl[$k1]["empr_ville"] ?></option>
                                        <?php
                                            # code...
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <script>

                            </script>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Pays</strong>
                                    </label>
                                    <select name="pays" id="pays" class="form-control">
                                        <option value="<?= $data["empr_pays"] ?>"><?= $data["empr_pays"] ?></option>

                                        <?php

                                        $vl = runQuery("SELECT DISTINCT(empr_pays) from empr where empr_pays != '" . $data["empr_pays"] . "' and empr_pays like '%ولاية%'  order by empr_pays asc ");
                                        foreach ($vl as $k1 => $v1) {
                                        ?>
                                            <option value="<?= $vl[$k1]["empr_pays"] ?>"><?= $vl[$k1]["empr_pays"] ?></option>
                                        <?php
                                            # code...
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                        <strong>Categorie</strong><br></label>
                                    <select name="categ" id="categ" class="form-control">
                                        <?php
                                        $cat = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr_categ where id_categ_empr= " . $data['empr_categ'] . " "))["libelle"];
                                        ?>
                                        <option value="<?= $data["empr_categ"] ?>"><?= $cat ?></option>

                                        <?php

                                        $vl = runQuery("SELECT * from empr_categ where libelle != '" . $cat . "' order by libelle asc ");
                                        foreach ($vl as $k1 => $v1) {
                                        ?>
                                            <option value="<?= $vl[$k1]["id_categ_empr"] ?>"><?= $vl[$k1]["libelle"] ?></option>
                                        <?php
                                            # code...
                                        }

                                        ?>
                                    </select>
                                    <script>
                                        $(function() {

                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                        <strong>Emplacement</strong><br></label>
                                    <select name="emp" id="emp" class="form-control">
                                        <?php
                                        $emp1 = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr_codestat where idcode= " . $data['empr_codestat'] . " "));

                                        ?>
                                        <option value="<?= $emp1["idcode"] ?>"><?= $emp1["libelle"] ?></option>
                                        <?php

                                        $vl = runQuery("SELECT * from empr_codestat where idcode != " . $emp1['idcode'] . " order by libelle asc ");
                                        foreach ($vl as $k1 => $v1) {
                                        ?>
                                            <option value="<?= $vl[$k1]["idcode"] ?>"><?= $vl[$k1]["libelle"] ?></option>
                                        <?php
                                            # code...
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Telephone</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_tel1"] ?>" type="text" id="tit4" placeholder="vide" name="tit4" style="">

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Profession</strong>
                                    </label>
                                    <select name="prof" id="prof" class="form-control">
                                        <option value="<?= $data["empr_prof"] ?>"><?= $data["empr_prof"] ?></option>

                                        <?php
                                        $pr = runQuery("SELECT DISTINCT(empr_prof) from empr where empr_prof!='" . $data["empr_prof"] . "' and empr_prof not like '' ");
                                        foreach ($pr as $kk => $vv) {
                                        ?>
                                            <option value="<?= $pr[$kk]["empr_prof"] ?>"><?= $pr[$kk]["empr_prof"] ?></option>
                                        <?php
                                            # code...
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="color: rgb(233,230,232);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Date d'adhésion</strong>
                                    </label>
                                    <input class="form-control" value="<?= $data["empr_date_adhesion"] ?>" type="date" id="dateAbonnement" placeholder="vide" name="dateAbonnement" style="">

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="" style="color: rgb(121,105,93);">
                                        <strong>Date d'expiration <i class="fas fa-lock"></i></strong>
                                    </label>
                                    <input disabled class="form-control" value="<?= $data["empr_date_expiration"] ?>" type="date" id="dateExp" placeholder="vide" name="dateExp" style="">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                        <strong>Sexe</strong><br></label>
                                    <select class="form-control" name="sexe" id="">
                                        <option value="<?= $data["empr_sexe"] ?>"><?php
                                                                                    ($data["empr_sexe"] == 1) ? print("Homme") : print("Femme");
                                                                                    ?></option>

                                        <?php

                                        switch ($data["empr_sexe"]) {
                                            case 1:
                                                # code...
                                                echo '
                                        <option value="2">Femme</option>
                                                
                                                ';
                                                break;
                                            case 2:
                                                echo '
                                        <option value="1">Homme</option>
                                                
                                                ';
                                                break;

                                            default:
                                                # code...
                                                break;
                                        } ?>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="id_empr" value="<?= $emprID ?>">



                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(243,185,73);">Enregistrer</button></div>
                    </form>
                    <script>
                        $(function() {
                            $("#prof").select2({
                                theme: "bootstrap4"
                            })
                            $("#ville").select2({
                                theme: "bootstrap4"
                            })
                            $("#pays").select2({
                                theme: "bootstrap4"
                            })
                            $("#edit").on("submit", (e) => {
                                e.preventDefault()
                                let form = $(this);
                                $.ajax({
                                    type: "post",
                                    url: "../Scripts/userManager.php?edit",
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
            /* let role = "<?= $role ?>"

            $(":input,select").prop("disabled", false)

            if (role == 0) {
                $(":input,select").prop("disabled", true)
                console.log(role);

            }*/
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