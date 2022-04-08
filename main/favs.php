<?php
$current = "favs";
require_once("./navigation.php");
$connect = Connect();
if (isset($_SESSION["login"])) {
    $user = GetUser($_SESSION["idUser"]);
    $favs = explode(",", $user["favs"]);


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $appName ?> Mes Favories</title>
    </head>

    <body>
        <div class="container-fluid" style="background: rgba(253,126,20,0);padding: 10px;">
            <div class="card shadow mx-auto pulse animated" style="width: 80vw;margin-top: 11px;margin-right: 0px;margin-left: 1px;">
                <div class="card-header py-3" style="background: rgb(249,250,250);">
                    <p style="color: rgb(122,106,94);font-size: 18px;font-family: Amiri, serif;"><strong>Liste des Favories &nbsp;</strong></p>
                </div>
                <div class="card-body" style="background: #f9fafa;">
                    <div class="row">

                        <div class="col-md-12 col-lg-9 mx-auto" style="height: 59px;">



                            <div class="text-md-end w-100 dataTables_filter" id="dataTable_filter"><input minlength="3" required name="q" id="srch" oninput="Search('srch','data')" class="shadow form-control form-control-sm" type="search" aria-controls="dataTable" placeholder="Recherche..." style="padding: 6px 12px;height: 38px;"><label class="form-label"></label></div>
                        </div>
                    </div>


                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="border-color: rgb(133, 135, 150);">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <td style="color: #7a6a5e;"><strong>Reference</strong></td>
                                    <td><strong style="color: #7a6a5e;">Titres de livre</strong></td>
                                    <td><strong style="color: #7a6a5e;">Auteur</strong></td>
                                    <td><strong style="color: #7a6a5e;">Location</strong></td>
                                    <td><strong style="color: #7a6a5e;">Categorie</strong></td>
                                    <td><strong style="color: #7a6a5e;">Section</strong></td>
                                    <td style="color: rgb(122,106,94);"><strong>Action</strong><br></td>
                                </tr>
                            </thead>
                            <tbody style="color: rgb(43,42,41);">
                                <?php
                                $class = "fas fa-bookmark";
                                $i = 0;

                                if ($favs[0] != "") {


                                    foreach ($favs as $k => $v) {
                                        $i++;
                                        $id1 = $favs[$k];
                                        $data = mysqli_fetch_array(mysqli_query($connect, "SELECT * from exemplaires E,notices N ,docs_location D,authors A,docs_section S  WHERE E.expl_id=$id1 and E.expl_notice=N.notice_id and E.expl_location=D.idlocation and N.ed1_id=A.author_id and E.expl_section=S.idsection"));
                                        # code...

                                ?>
                                        <tr class="data">
                                            <td style="color: #7a6a5e;"><?= "#" . $data["expl_cb"] ?> </td>
                                            <td style="color: #7a6a5e;"><?php
                                                                        ($data["tit1"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data["tit1"]) . "<br>" : print("");
                                                                        ($data["tit2"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data["tit2"]) . "<br>" : print("");
                                                                        ($data["tit3"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data["tit3"]) . "<br>" : print("");
                                                                        ($data["tit4"] != "") ? print ("<i class='fa fa-circle' style='font-size:4px'></i>  " . $data["tit4"]) . "<br>" : print("");
                                                                        ?></td>
                                            <td style="color: #7a6a5e;"><?= $data["author_rejete"] . " " . $data["author_name"]  ?></td>
                                            <td><?= $data["location_libelle"] ?></td>
                                            <td style="color: #7a6a5e;"><?= $data["index_l"] ?></td>
                                            <td style="color: #7a6a5e;"><?= $data["section_libelle"] ?></td>
                                            <td class="d-flex" style="justify-content: space-between;border:unset">
                                                <a target="_blank" class="text-dark bg-transparent " style="border:none" href="./bookDetails.php?explID=<?= $data["expl_id"] ?>&noticeID=<?= $data["notice_id"] ?>"><i class="fa fa-eye"></i></a>
                                                <?php if (isset($_SESSION["login"])) {

                                                ?>
                                                    <form id="fav<?= $i ?>">
                                                        <input type="hidden" id="expl_id<?= $i ?>" name="expl_id<?= $i ?>" value="<?= $data["expl_id"] ?>">

                                                        <button type="submit" class=" bg-transparent text-danger border-0"><i id="icon<?= $i ?>" class="<?= $class ?>"></i></button>
                                                    </form>
                                                <?php } ?>
                                                <script>
                                                    $(function() {
                                                        $("#fav<?= $i ?>").on("submit", (e) => {
                                                            e.preventDefault();
                                                            let expl_id = $("#expl_id<?= $i ?>").val();
                                                            $.ajax({
                                                                type: "post",
                                                                url: "../Scripts/booksManager.php?Fav",
                                                                data: {
                                                                    expl_id: expl_id
                                                                },
                                                                success: function(res) {
                                                                    $("#icon<?= $i ?>").removeAttr("class");

                                                                    if (res == 1) {
                                                                        $("#icon<?= $i ?>").addClass("fas fa-bookmark")
                                                                    } else {
                                                                        $("#icon<?= $i ?>").addClass("far fa-bookmark")

                                                                    }
                                                                    console.log(res);
                                                                },
                                                                error: (e) => {
                                                                    console.log(e.responseText);
                                                                    alertify.error("Erreur de serveur .. ")
                                                                }
                                                            });
                                                        })
                                                    });
                                                </script>

                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td>Vous n'avez pas encore ajouté des favories</td>
                                    </tr>

                                <?php
                                } ?>
                            </tbody>
                            <tfoot style="color: rgb(43,42,41);">
                                <tr>
                                    <td style="color: #7a6a5e;"><strong>Reference</strong></td>
                                    <td><strong style="color: #7a6a5e;">Titres de livre</strong></td>
                                    <td><strong style="color: #7a6a5e;">Auteur</strong></td>
                                    <td><strong style="color: #7a6a5e;">Location</strong></td>
                                    <td><strong style="color: #7a6a5e;">Categorie</strong></td>
                                    <td><strong style="color: #7a6a5e;">Section</strong></td>
                                    <td style="color: rgb(122,106,94);"><strong>Action</strong><br></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <style>
                        .pag {
                            width: 50vw;
                            max-width: 50vw;
                            position: relative;
                            overflow: auto;
                        }
                    </style>

                </div>
            </div>
        </div>
        </div>
        <script>
            $("#")

            function Search(IDinput, ClassItem) {
                var input = document.getElementById(IDinput);
                var filter = input.value.toLowerCase();
                var element = document.getElementsByClassName(ClassItem);



                for (i = 0; i < element.length; i++) {

                    if (element[i].innerText.toLowerCase().includes(filter)) {
                        element[i].style.display = "table-row";

                    } else {
                        element[i].style.display = "none";

                    }

                }

            }
        </script>
        </div>
        <?php



        require_once("./footer.php"); ?>

        </div>

    </body>

    </html>
<?php } else { ?>
    <script>
        ReloadIndex()
    </script>

<?php
} ?>