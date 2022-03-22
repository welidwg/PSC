<?php
$current = "accueil";
require_once("./navigation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?> Accueil</title>
</head>

<body>
    <div class="row pulse animated">
        <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
            <h1 style="margin-top: 57px;color: #7a6a5e;font-family: Aldrich, sans-serif;font-size: 5vh;font-weight: bold;">Bienvenue !&nbsp;</h1>
            <p style="margin-top: 48px;color: #7a6a5e;font-size: 3vh;font-weight: bold;"><strong>Médiathèque régionale de Monastir</strong> est une plateforme destinée aux adhérents et aux personnels du la bibliothèque publique du Monastir pour le but de la numérisation de la bibliothèque et facilite l'accès aux différents types des documents.&nbsp; </p>
        </div>
        <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 phone-holder" style="text-align: center;padding: 56px;"><img class="img-fluid" src="../assets/img/logobiblio[black].png" style="box-shadow: 2px 2px 14px;width: 250px;padding: 25px;"></div>
    </div>
    </div>

    </div>
    <?php require_once("./footer.php"); ?>

    </div>

</body>

</html>