<?php
$current = "addAdherant";
require_once("./navigation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Ajouter un adhérant</title>
</head>

<body>

    <div class="container-fluid" style="padding: 100px;">


        <div class="row mb-3">

            <div class="col-lg-12">

                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3" style="background: #f7f6f6;">
                                <p style="color: rgb(236,155,33);font-family: Amiri, serif;font-size: 18px;text-align: center;"><strong>Ajouter un adhérant </strong></p>
                            </div>
                            <div class="card-body">
                                <script>
                                    $(function() {
                                        $("#add").on("submit", function(e) {
                                            e.preventDefault()
                                            $.ajax({
                                                type: "post",
                                                url: "../Scripts/userManager.php?Add",
                                                data: $("#add").serialize(),
                                                dataType: "json",
                                                success: function(res) {
                                                    alertify.success(res);
                                                    console.log(res);
                                                },
                                                error: (e) => {
                                                    console.log(e.responseText);
                                                }
                                            });
                                        });

                                    });
                                </script>
                                <form id="add">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Code d'abonnement</strong><br></label>
                                                <input class="form-control" type="number" id="code" placeholder="Code" name="code" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Date d'abonnement</strong><br></label>
                                                <input class="form-control" type="date" id="date" placeholder="Date" name="dateAbonnement" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Nom</strong><br></label>
                                                <input class="form-control" type="text" id="nom" placeholder="Nom" name="nom" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Prénom</strong><br></label>
                                                <input class="form-control" type="text" id="prenom" placeholder="prenom" name="prenom" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Categorie</strong><br></label>
                                                <select name="categ" id="categ" class="form-control">
                                                    <option value="">choisir une categorie</option>

                                                    <?php

                                                    $vl = runQuery("SELECT * from empr_categ order by libelle asc ");
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
                                                    <option value="">choisir un emplacement</option>
                                                    <?php

                                                    $vl = runQuery("SELECT * from empr_codestat order by libelle asc ");
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Pays</strong><br></label>
                                                <select name="pays" id="pays" class="form-control">
                                                    <option value="">choisir une pays</option>

                                                    <?php

                                                    $vl = runQuery("SELECT DISTINCT(empr_pays) from empr order by empr_pays asc ");
                                                    foreach ($vl as $k1 => $v1) {
                                                    ?>
                                                        <option value="<?= $vl[$k1]["empr_pays"] ?>"><?= $vl[$k1]["empr_pays"] ?></option>
                                                    <?php
                                                        # code...
                                                    }

                                                    ?>
                                                </select>
                                                <script>
                                                    $(function() {
                                                        $("#pays").select2({
                                                            theme: 'bootstrap4',

                                                        })
                                                        $("#ville").select2({
                                                            theme: 'bootstrap4',

                                                        })
                                                        $("#prof").select2({
                                                            theme: 'bootstrap4',

                                                        })
                                                        $("#categ").select2({
                                                            theme: 'bootstrap4',

                                                        })
                                                        $("#emp").select2({
                                                            theme: 'bootstrap4',

                                                        })
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Ville</strong><br></label>
                                                <select name="ville" id="ville" class="form-control">
                                                    <option value="">choisir une ville</option>
                                                    <?php

                                                    $vl = runQuery("SELECT DISTINCT(empr_ville) from empr order by empr_ville asc ");
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
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Code Postal</strong><br></label>
                                                <input class="form-control" type="number" id="CodeP" placeholder="Code Postal" name="CodeP" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Adresse</strong><br></label>
                                                <input class="form-control" type="text" id="adresse" placeholder="Adresse" name="adresse" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Profession</strong><br></label>
                                                <select name="prof" id="prof" class="form-control">
                                                    <option value="">Chosir une profession</option>

                                                    <?php
                                                    $pr = runQuery("SELECT DISTINCT(empr_prof) from empr ");
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
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Date de naissance</strong><br></label>
                                                <input class="form-control" type="date" id="date" placeholder="Date" name="dateNaissance" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Email</strong><br></label>
                                                <input class="form-control" type="email" id="email" placeholder="email" name="email" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Téléphone</strong><br></label>
                                                <input class="form-control" type="number" id="tel" placeholder="Téléphone" name="tel" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Sexe</strong><br></label>
                                                <select class="form-control" name="sexe" id="">
                                                    <option value="1">Homme</option>
                                                    <option value="2">Femme</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(241,183,72);font-size: 16px;font-family: Amiri, serif;border-color: rgb(241,183,72);">Ajouter</button></div>
                                </form>
                            </div>
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