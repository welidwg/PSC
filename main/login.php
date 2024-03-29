<?php
$current = "login";
require_once("./navigation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Connexion</title>
</head>

<body>
    <div class="container pulse animated" style="padding: 26px;">
        <div class="border rounded mx-auto p-5" style="background: #dfdadc;border-radius: 24px;width: 60vw;"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.html" style="border-width: 0px;"><img src="../assets/img/logobiblio.png" style="width: 100px;margin-left: -15px;"></a>
            <div class="text-center">
                <h1 style="color: #7a6a5e;font-weight: bold;font-family: Amiri, serif;font-size: 28px;"><strong>Connexion</strong><br></h1>
            </div>
            <form class="user" id="login">
                <div class="mb-3"><input required class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" name="email" style="border-color: rgb(239,236,232);color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3"><input required class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Mot de passe" name="password" style="border-color: rgb(239,236,232);border-top-color: rgb(133,;border-right-color: 135,;border-bottom-color: 150);border-left-color:135,;color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3">
                    <div class="custom-control custom-checkbox small"></div>
                </div><button class="btn btn-primary d-block btn-user w-100" type="submit" style="background: #EE9B00;border-color: rgb(239,236,232);color: #f9fafa;font-size: 18px;font-family: Amiri, serif;">Se connecter</button>
            </form>
            <div class="text-center" style="margin-top: 15px;"><a class="small" id="forget" style="border-color: rgb(239,236,232);color: rgb(43,42,41);font-family: Amiri, serif;font-size: 16px;">Mot de passe oubliée ?</a></div>
            <div class="text-center"><a class="small" href="./register.php" style="border-color: rgb(239,236,232);color: rgb(41,40,39);font-family: Amiri, serif;font-size: 16px;">Vous n'avez pas un compte ? Créez un maintenant !</a></div>
        </div>
    </div>
    </div>
    <script>
        $(function() {
            $("#forget").on("click", (e) => {
                alertify.prompt("Récupération du mot de passe", "S'il vous plaît saisissez votre email : ", "", (e, val) => {
                    if (val == "") {
                        alertify.error("Veuillez saisir votre email pour continuer !")
                        e.cancel = true;
                    } else {

                        $.ajax({
                            type: "post",
                            url: "../Scripts/userManager.php?CheckMail",
                            data: {
                                email: val
                            },
                            dataType: "Json",
                            beforeSend: () => {
                                alertify.notify("Vérification..")

                            },
                            success: function(res) {
                                if (res.code) {
                                    localStorage.setItem("code", res.code);
                                    alertify.prompt("Confirmation", "Un email est envoyé sur votre boite de récéption avec un code de confirmation .<br> Saissez le code reçu s'il vous plaît ", "", (ev, value) => {
                                        ev.cancel = true;
                                        if (value == "") {
                                            alertify.error("Veuillez saisir le code !");
                                        } else {
                                            if (value == localStorage.getItem("code")) {
                                                alertify.prompt("Nouveau mot de passe", "Veuillez saisir attentivement votre nouveau mot de passe", "", (evv, val1) => {
                                                    if (val1 == "") {
                                                        evv.cancel = true;
                                                        alertify.error("Veuillez saisir un nouveau mot de passe !");

                                                    } else {
                                                        $.ajax({
                                                            type: "post",
                                                            url: "../Scripts/userManager.php?ChangePassword",
                                                            data: {
                                                                password: val1,
                                                                email: val
                                                            },
                                                            dataType: "Json",
                                                            beforeSend: () => {
                                                                alertify.notify("operation en cours ...")

                                                            },
                                                            success: function(res) {
                                                                alertify.success(res.msg);
                                                                localStorage.removeItem("code");

                                                            },
                                                            error: (e) => {
                                                                alertify.error(e.responseJSON.msg)
                                                                console0log(e.responseJSON.error)

                                                            }
                                                        });
                                                    }

                                                }, (e) => {}).set({
                                                    type: "password",
                                                    labels: {
                                                        ok: "confirmer",
                                                        cancel: "annuler"
                                                    }
                                                })
                                            } else {
                                                alertify.error("code non valide");

                                            }
                                        }
                                    }, (c) => {})

                                }


                            },
                            error: (e) => {
                                alertify.error(e.responseJSON.msg)

                            }
                        });

                    }
                }, (e) => {}).set({
                    type: "email",
                    labels: {
                        ok: "Continuer",
                        cancel: "Annuler"
                    }
                })
            })


            $("#login").on("submit", (e) => {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "../Scripts/auth.php?login",
                    data: $("#login").serialize(),
                    success: function(res) {
                        console.log(res);
                        switch (res) {
                            case "0":
                                alertify.error("Utilisateur non trouvée !");
                                break;
                            case "10":
                                alertify.error("Verifier votre mot de passe !");

                                break;
                            case "1":
                                window.location.href = "./index.php";
                                break;

                            default:
                                break;
                        }
                    }
                });
            })
        });
    </script>

    </div>
    <?php require_once("./footer.php"); ?>

    </div>
    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <a class="border rounded d-inline scroll-to-top" href="#page-top" style="background: rgb(233,153,32);"><i class="fas fa-angle-up"></i></a>

</body>

</html>