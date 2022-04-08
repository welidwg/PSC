<?php
$current = "addUser";
require_once("./navigation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Ajouter un Utilisateur</title>
</head>

<body>

    <div class="container-fluid" style="padding: 100px;">


        <div class="row mb-3">

            <div class="col-lg-12">

                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3" style="background: #f7f6f6;">
                                <p style="color: rgb(236,155,33);font-family: Amiri, serif;font-size: 18px;text-align: center;"><strong>Ajouter un Admin </strong></p>
                            </div>
                            <div class="card-body">
                                <script>
                                    $(function() {
                                        $("#add").on("submit", function(e) {
                                            e.preventDefault()
                                            $.ajax({
                                                type: "post",
                                                url: "../Scripts/userManager.php?AddUser",
                                                data: $("#add").serialize(),
                                                dataType: "json",
                                                success: function(res) {
                                                    alertify.success(res);
                                                },
                                                error: (e) => {
                                                    alertify.error(e.responseJSON.msg);
                                                    console.log(e.responseJSON.error);
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
                                                    <strong>Email</strong><br></label>
                                                <input class="form-control" type="email" id="email" placeholder="exp:email@domain.com" name="email" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Nom</strong><br></label>
                                                <input class="form-control" type="text" id="nom" placeholder="Nom" name="nom" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Mot de passe </strong><br></label>
                                                <input class="form-control" type="password" id="password" placeholder="Mot de passe" name="password" style="">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Confirmer mot de passe</strong><br></label>
                                                <input class="form-control" type="password" id="confirm" placeholder="Confirmer votre mot de passe" name="confirm" style="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;">
                                                    <strong>Cin</strong><br></label>
                                                <input type="number" name="cin" class="form-control" placeholder="exp : 06123456">
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