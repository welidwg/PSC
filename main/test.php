<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
    <style>
        * {
            font-family: Arial;
        }
    </style>
</head>

<body>
    <form action="" method="get">
        <select name="search" id="">
            <?php if (isset($_GET["search"])) {
            ?>
                <option value="<?= $_GET["search"] ?>"><?php switch ($_GET["search"]) {
                                                            case 1:
                                                                echo "titre";
                                                                # code...
                                                                break;
                                                            case 2:
                                                                echo "Auteur";
                                                                # code...
                                                                break;
                                                            case 3:
                                                                echo "Categorie";
                                                                # code...
                                                                break;
                                                            case 4:
                                                                echo "language";
                                                                # code...
                                                                break;
                                                            case 5:
                                                                echo "type";
                                                                # code...
                                                                break;
                                                            default:
                                                                # code...
                                                                break;
                                                        } ?></option>

            <?php
            } ?>
            <option value="1">titre</option>
            <option value="2">Auteur</option>
            <option value="3">Categorie</option>
            <option value="4">language</option>
            <option value="5">type</option>
        </select>
        <input name="q" value="<?php if (isset($_GET["q"])) {
                                    echo $_GET["q"];
                                } ?>" type="text" placeholder="search" />
    </form>

    <?php
    // Send a raw HTTP header
    require_once("../Scripts/utiles.php");
    $connect = Connect();
    if (isset($_GET['page']) && !empty($_GET['page'])) {
        $currentPage = (int) strip_tags($_GET['page']);
    } else {
        $currentPage = 1;
    }
    $parPage  = 100;

    if ($connect) {
        if (isset($_GET["q"])) {
            $val = $_GET["q"];
            $nbArticles = mysqli_num_rows(mysqli_query($connect, "SELECT * from notices N , exemplaires E WHERE N.notice_id=E.expl_notice and  tit1 like '%$val%' or tit1 like '$val'"));
            $pages = ceil($nbArticles  / $parPage);
            $premier = ($currentPage * $parPage) - $parPage;
            switch ($_GET["search"]) {
                case 1:
                    $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and  tit1 like '%$val%' or tit2 like '%$val%' or tit3 like '%$val%' or tit4 like '%$val%'  Limit $premier,$parPage ");
                    break;
                case 2:
                    $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and author_name like '%$val%' or author_rejete like '%$val%'   Limit $premier,$parPage ");

                    break;
                case 5:
                    $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A , docs_type T WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id and T.idtyp_doc=E.expl_typdoc  and tdoc_libelle like '%$val%' Limit $premier,$parPage ");

                    break;
                default:
                    # code...
                    break;
            }
        } else {
            $nbArticles = mysqli_num_rows(mysqli_query($connect, "SELECT * from notices N , exemplaires E WHERE N.notice_id=E.expl_notice"));
            $pages = ceil($nbArticles  / $parPage);
            $premier = ($currentPage * $parPage) - $parPage;
            $data = runQuery("SELECT * from notices N , exemplaires E,docs_location D,authors A WHERE N.notice_id=E.expl_notice and E.expl_location=D.idlocation and N.ed1_id=A.author_id LIMIT $premier,$parPage");
        }


        if (!empty($data)) {
            foreach ($data as $key => $value) {
                echo "<p lang='ar'> tit1:" . $data[$key]["tit1"] . " /  tit2 : " . $data[$key]["tit2"] . "/ tit3" . $data[$key]["tit3"] . "/tit4" . $data[$key]["tit4"] . "/ location : " . $data[$key]["location_libelle"] . " /auteur : " . $data[$key]["author_name"] . " " . $data[$key]["author_rejete"] . " </p>";
            }
        } else {
            echo "empty";
        }
    }
    ?>
    <nav>
        <ul class="pagination">
            <li class="page-item <?php ($currentPage == 1) ? print("disabled") : "" ?>"><a class="page-link" href="?page=<?php echo $currentPage - 1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
            <?php for ($page = 1; $page <= $pages; $page++) : ?>

                <li class="page-item <?php ($currentPage == $page) ? print("active") : "" ?>"><a class="page-link" href="<?php if (isset($_GET["q"])) {
                                                                                                                                echo "?search=" . $_GET["search"] . "&q=" . $_GET["q"] . "&page=$page";
                                                                                                                            } else {
                                                                                                                                echo "?page=$page";
                                                                                                                            } ?>"><?php echo $page ?></a></li>
            <?php endfor ?>

            <li class="page-item <?php ($currentPage == $pages) ? print("disabled") : "" ?>"><a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
        </ul>
    </nav>
</body>

</html>