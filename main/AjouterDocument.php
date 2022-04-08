<?php
$current = "addDoc";
require_once("./navigation.php");
if (isset($_GET["ref"])) {
    $ref = $_GET["ref"];
    $check = GetNumRows("SELECT * from exemplaires where expl_cb='$ref'");

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
                                    <?php if ($check > 0) {
                                        $expl=GetDocByRef($ref);
                                        $idnotice=$expl["expl_notice"];
                                         ?>

                                    <?php } ?>
                                    <form id="add">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="Ref" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Reference</strong><br></label><input class="form-control" type="text" id="username" placeholder="Reference" name="Ref" style="background: rgb(247,246,246);"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="email" style="font-size: 18px;font-family: Amiri, serif;color: rgb(122,106,94);"><strong>Type de document</strong><br></label><input class="form-control" type="email" id="email" placeholder="user@example.com" name="email" style="background: rgb(247,246,246);"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for=" nom prenom auteur" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Auteur</strong></label><input class="form-control" type="text" id="first_name" placeholder=" nom et prenom d'auteur" name="auteur" style="background: rgb(247,246,246);"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="qte" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>quantite</strong></label><input class="form-control" type="text" id="last_name" placeholder="exp:10 livre" name="qte" style="background: rgb(247,248,251);"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="first_name" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Cathegorie</strong><br></label><input class="form-control" type="text" id="first_name-1" placeholder="exp:drama" name="cathegorie" style="background: rgb(247,246,246);"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="date" style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>date&nbsp;impression</strong><br></label><input class="form-control" type="date" name="date" style="background: rgb(247,246,246);"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="address" style="color: rgb(122,111,120);font-family: Amiri, serif;font-size: 18px;"><strong>localisation par médiathéque</strong></label>
                                                    <div class="dropdown"><button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="background: rgb(247,246,246);color: rgb(133,135,150);border-color: #dddee9;">Médiathéque&nbsp;</button>
                                                        <div class="dropdown-menu" style="background: rgb(247,248,251);"><a class="dropdown-item" href="#">Monastir</a><a class="dropdown-item" href="#">Sahline</a><a class="dropdown-item" href="#">OUardanine</a></div>
                                                    </div>
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