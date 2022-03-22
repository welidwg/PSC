<?php
$current = "signup";
require_once("./navigation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Créer Votre Compte</title>
</head>

<body>
    <div class="container pulse animated" style="padding: 26px;">
        <div class="border rounded mx-auto p-5" style="background: #dfdadf;border-radius: 22px;width: 60vw;"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php" style="border-width: 0px;"><img src="../assets/img/logobiblio.png" style="width: 100px;margin-left: -15px;"></a>
            <div class="text-center">
                <h1 style="color: #7a6a5e;font-weight: bold;font-family: Amiri, serif;font-size: 28px;"><strong>Créer Votre compte</strong><br></h1>
            </div>
            <form class="user" id="register">
                <div class="mb-3"><input required class="form-control form-control-user" id="email" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" name="email" style="border-color: rgb(239,236,232);color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3"><input required class="form-control form-control-user" type="number" id="exampleInputPassword-1" placeholder="Code d'abonnement" name="code" style="border-color: rgb(239,236,232);border-top-color: rgb(133,;border-right-color: 135,;border-bottom-color: 150);border-left-color: 135,;color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3"><input minlength="5" required id="password" class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Mot de passe" name="password" style="border-color: rgb(239,236,232);border-top-color: rgb(133,;border-right-color: 135,;border-bottom-color: 150);border-left-color: 135,;color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3"><input required id="confirm" class="form-control form-control-user" type="password" id="exampleInputPassword-2" placeholder="Confirmez votre mot de passe" name="confirm" style="border-color: rgb(239,236,232);border-top-color: rgb(133,;border-right-color: 135,;border-bottom-color: 150);border-left-color: 135,;color: rgb(43,42,41);background: rgb(249,250,250);font-size: 13.8px;font-family: Amiri, serif;"></div>
                <div class="mb-3">
                    <div class="custom-control custom-checkbox small"></div>
                </div><button id="submit" class="btn btn-primary d-block btn-user w-100" type="submit" style="background: #EE9B00;border-color: rgb(239,236,232);color: #f9fafa;font-size: 18px;font-family: Amiri, serif;">Créer un compte</button>
            </form>
            <div class="text-center" style="margin-top: 15px;"></div>
            <div class="text-center"><a class="small" href="./login.php" style="border-color: rgb(239,236,232);color: rgb(41,40,39);font-family: Amiri, serif;font-size: 16px;">Vous avez un compte ? Connectez-vous maintenant !</a></div>
        </div>
    </div>
    </div>
    <script>
        $(function() {
            $("#confirm").on("keyup", (e) => {
                let pass = $("#password").val();
                let confirm = $("#confirm").val();
                if (pass !== confirm) {
                    $("#submit").attr("disabled", true);
                    $("#confirm").css("border", "1px solid red");

                } else {
                    $("#submit").attr("disabled", false);
                    $("#confirm").css("border", "none");


                }
            })
            $("#email").on("keyup", (e) => {
                let val = e.target.value;
                $.ajax({
                    type: "post",
                    url: "../Scripts/auth.php?VerifMail",
                    data: {
                        email: val
                    },
                    success: function(res) {
                        switch (res) {
                            case "1":
                                $("#email").css("border", "1px solid red");
                                $("#submit").attr("disabled", true);
                                alertify.error("Email déjà existant !");

                                break;

                            default:
                                $("#email").css("border", "none");
                                $("#submit").attr("disabled", false);

                                break;
                        }
                    }
                });
            })
            $("#register").on("submit", (e) => {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "../Scripts/auth.php?register",
                    data: $("#register").serialize(),
                    success: function(res) {
                        switch (res) {
                            case "0":
                                alertify.alert("Erreur", "Ce code est inexistant ou il n'est pas encore enregistré. Veuillez contactez la médiathèque");

                                break;
                            case "1":
                                alertify.success("Compte crée avec succées ! ")
                                setTimeout(() => {
                                    window.location.href = "./login.php";
                                }, 700);

                                break;
                            case "2":
                                alertify.alert("Erreur", "L'adhérant de ce code est déjà inscrit au site !");


                                break;


                            default:
                                $("#submit").attr("disabled", false);

                                break;
                        }
                    },
                    error: (res) => {
                        alertify.error("Erreur")
                        console.log(res.responseText);
                    }
                });
            })
        });
    </script>
    </div>
    <?php require_once("./footer.php"); ?>

    </div>

</body>

</html>