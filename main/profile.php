<?php
$current = "profile";
require_once("./navigation.php");
if (isset($_SESSION["login"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName ?> Profile</title>
    </head>

    <body>
        <div class="container-fluid" style="padding: 100px;">
            <div class="row pulse animated mb-3">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body text-center shadow"><img class="rounded-circle img-fluid mb-3 mt-4" src="<?php if ($usr["avatar"] != "") echo "../assets/img/avatars/" . $usr["avatar"];
                                                                                                                        else echo "../assets/img/avatar.png"; ?>" width="160" height="160">
                            <script>
                                $(function() {
                                    $("#avatar").on("change", (e) => {
                                        console.log(e.target.files);

                                    })
                                });
                            </script>
                            <form id="avatarChange" enctype="multipart/form-data">
                                <div class="mb-3"><label class="form-label" for="avatar" style="color: rgb(121,105,93);font-family: Amiri, serif;font-size: 18px;font-weight: bold;"><strong>Choisissez une photo <i class="fas fa-pen"></i> &nbsp;</strong></label><input hidden class="form-control" value="<?= $_SESSION["avatar"] ?>" type="file" id="avatar" name="avatar" style="background: rgb(247,246,246);"></div>

                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(241,184,73);">Enregistrer</button></div>

                            </form>
                            <script>
                                $(function() {
                                    $("#avatarChange").on("submit", (e) => {
                                        e.preventDefault();
                                        let form = $("#avatarChange")[0];
                                        let formdata = new FormData(form);
                                        $.ajax({
                                            type: "post",
                                            url: "../Scripts/profileManager.php?avatar",
                                            data: formdata,
                                            processData: false,
                                            contentType: false,
                                            success: function(res) {
                                                if (res == 1) {
                                                    alertify.success("Enregistrée !");
                                                    setTimeout(() => {
                                                        window.location.reload()
                                                    }, 700);

                                                } else {
                                                    alertify.error("Erreur de serveur !");
                                                    console.log(res);

                                                }
                                                console.log(res);
                                            }
                                        });
                                    })
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">

                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3" style="background: #f7f6f6;">
                                    <p style="color: rgb(231,151,32);font-family: Amiri, serif;font-size: 18px;text-align: center;"><strong>Informations générales :</strong></p>
                                </div>
                                <div class="card-body">
                                    <form id="info">
                                        <div class="row" style="color: rgb(233,230,232);">
                                            <?php if ($role == 0) { ?>
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="username" style="color: rgb(121,105,93);"><strong>Code d'abonnement</strong> <i class="fa fa-lock"></i> </label><input readonly value="<?= $_SESSION["code"] ?>" disabled class="form-control" type="text" id="code" placeholder="user" name="username" style="background: rgb(247,246,246);"></div>
                                                </div>
                                            <?php }  ?>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="email" style="color: rgb(121,105,93);font-family: Amiri, serif;font-size: 18px;font-weight: bold;"><strong>Adresse e-mail&nbsp;</strong></label><input class="form-control" value="<?= $_SESSION["email"] ?>" type="email" id="email" placeholder="user@example.com" name="email" style="background: rgb(247,246,246);"></div>
                                            </div>
                                            <?php if ($role == 1 || $role == 2) {
                                            ?>
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="" style="color: rgb(121,105,93);font-family: Amiri, serif;font-size: 18px;font-weight: bold;"><strong>Nom&nbsp;</strong></label><input class="form-control" value="<?= $usr["nom"] ?>" type="text" id="nom" placeholder="votre nom" name="nom" style="background: rgb(247,246,246);"></div>
                                                </div>

                                            <?php
                                            } ?>
                                        </div>
                                        <?php if ($role == 0) { ?>
                                            <div class="row" style="color: rgb(233,230,232);">
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="first_name" style="color: rgb(121,105,98);font-family: Amiri, serif;font-size: 18px;font-weight: bold;"><strong>Nom</strong></label><input value="<?= $empr["empr_nom"] ?>" class="form-control" type="text" id="first_name" placeholder="nom" name="nom" style="background: rgb(247,246,246);"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="last_name" style="color: rgb(121,105,93);font-family: Amiri, serif;font-size: 18px;"><strong>Prénom</strong></label><input class="form-control" value="<?= $empr["empr_prenom"] ?>" type="text" id="last_name" placeholder="Prenom" name="prenom" style="background: rgb(247,246,246);"></div>
                                                </div>
                                            </div>



                                            <div class="mb-3">
                                                <label class="form-label" for="maticule" style="color: rgb(121,105,93);font-size: 18px;font-weight: bold;">
                                                    Profession:
                                                    <br></label>
                                                <select name="prof" id="prof" class="form-control">
                                                    <option value="<?= $empr["empr_prof"] ?>"><?= $empr["empr_prof"] ?></option>

                                                    <?php
                                                    $prof = $empr["empr_prof"];
                                                    $pr = runQuery("SELECT DISTINCT(empr_prof) from empr where empr_prof!='$prof'");
                                                    foreach ($pr as $kk => $vv) {
                                                    ?>
                                                        <option value="<?= $pr[$kk]["empr_prof"] ?>"><?= $pr[$kk]["empr_prof"] ?></option>
                                                    <?php
                                                        # code...
                                                    }

                                                    ?>
                                                </select>
                                                <script>
                                                    $(function() {
                                                        $("#prof").select2()
                                                    });
                                                </script>
                                            </div>
                                        <?php }  ?>
                                        <div class="mb-3"><label class="form-label" for="mot de passe" style="color: rgb(121,105,93);font-weight: bold;font-family: Amiri, serif;font-size: 18px;">Nouveau Mot de passe :</label><input class="form-control" type="password" style="background: rgb(247,246,246);" placeholder="***********" name="password"></div>
                                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(243,185,73);">Enregistrer</button></div>
                                    </form>
                                    <script>
                                        $(function() {
                                            $("#info").on("submit", (e) => {
                                                e.preventDefault();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "../Scripts/profileManager.php?info",
                                                    data: $('#info').serialize(),
                                                    success: function(res) {
                                                        if (res == false) {
                                                            alertify.error("Cet Email est déjà utilisé par un autre utilisateur");

                                                        } else if (res == 1) {
                                                            alertify.success("Enregistrée !");
                                                            setTimeout(() => {
                                                                window.location.reload()
                                                            }, 700);

                                                        } else {
                                                            alertify.error("Erreur de serveur !");
                                                            console.log(res);

                                                        }



                                                    }
                                                });
                                            })
                                        });
                                    </script>
                                </div>
                            </div>
                            <?php if ($role == 0) { ?>

                                <div class="card shadow">
                                    <div class="card-header py-3" style="background: rgb(247,246,246);">
                                        <p class="text-center" style="color: rgb(229,150,32);font-size: 18px;font-family: Amiri, serif;"><strong>Contact :</strong></p>
                                    </div>
                                    <div class="card-body">
                                        <form id="contact">
                                            <div class="mb-3"><label class="form-label" for="address" style="color: rgb(121,105,93);font-weight: bold;font-family: Amiri, serif;font-size: 18px;">Address :</label><input class="form-control" type="text" value="<?= $empr["empr_adr1"] ?>" id="address" placeholder="rue exemple exemple" name="address" style="color: rgb(43,42,41);background: rgb(247,246,246);"></div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="city" style="color: rgb(121,105,93);font-family: Amiri, serif;font-size: 18px;"><strong>Ville :
                                                            </strong></label>
                                                        <select name="ville" id="ville" class="form-control">
                                                            <option value="<?= $empr["empr_ville"] ?>"><?= $empr["empr_ville"] ?></option>

                                                            <?php
                                                            $ville = $empr["empr_ville"];
                                                            $vl = runQuery("SELECT DISTINCT(empr_ville) from empr where empr_ville!='$ville'");
                                                            foreach ($vl as $k => $v) {
                                                            ?>
                                                                <option value="<?= $vl[$k]["empr_ville"] ?>"><?= $vl[$k]["empr_ville"] ?></option>
                                                            <?php
                                                                # code...
                                                            }

                                                            ?>
                                                        </select>
                                                        <script>
                                                            $(function() {
                                                                $("#ville").select2()
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="country" style="color: rgb(121,105,93);font-weight: bold;font-family: Amiri, serif;font-size: 18px;">Pays : </label>
                                                        <select name="pays" id="pays" class="form-control">
                                                            <option value="<?= $empr["empr_pays"] ?>"><?= $empr["empr_pays"] ?></option>

                                                            <?php
                                                            $ville = $empr["empr_pays"];
                                                            $vl = runQuery("SELECT DISTINCT(empr_pays) from empr where empr_pays!='$ville'");
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
                                                                $("#pays").select2()
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3"><label class="form-label" for="tel" style="color: rgb(121,105,93);font-weight: bold;font-family: Amiri, serif;font-size: 18px;">Numéro Telephone<br></label><input class="form-control" id="tel" type="number" value="<?= $empr["empr_tel1"] ?>" name="tel" min="11111111" max="99999999" placeholder="xx xxx xxx" style="background: rgb(247,246,246);"></div>
                                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="background: rgb(240,183,72);border-color: rgb(240,183,72);">Enregitrer</button></div>
                                        </form>
                                    </div>

                                    <script>
                                        $(function() {
                                            $("#contact").on("submit", (e) => {
                                                e.preventDefault();
                                                $.ajax({
                                                    type: "post",
                                                    url: "../Scripts/profileManager.php?contact",
                                                    data: $("#contact").serialize(),
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
                                                    },
                                                    error: (e) => {
                                                        alertify.error(e.responseText);

                                                    }
                                                });
                                            })
                                        });
                                    </script>

                                </div>
                            <?php }  ?>

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
<?php } ?>