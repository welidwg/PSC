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
    <title><?= $appName ?> Plus</title>
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .l-bg-cherry {
            background: linear-gradient(to right, #493240, #f09) !important;
            color: #fff;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #dd7c05, #ffba56) !important;
            color: #fff;
        }

        .l-bg-orange-dark1 {
            background: linear-gradient(to right, #fc9b24, #ffba56) !important;
            color: #fff;
        }

        .l-bg-orange1 {
            background: linear-gradient(to right, #eba550, #ffba56) !important;
            color: #fff;
        }

        .card .card-statistic-3 .card-icon-large .fas,
        .card .card-statistic-3 .card-icon-large .far,
        .card .card-statistic-3 .card-icon-large .fab,
        .card .card-statistic-3 .card-icon-large .fal {
            font-size: 80px;
        }

        .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 10px;
            color: #000;
            position: absolute;
            right: 5px;
            top: 20px;
            opacity: 0.1;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .l-bg-green {
            background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
            color: #fff;
        }

        .l-bg-orange {
            background: linear-gradient(to right, #f9900e, #ffba56) !important;
            color: #fff;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="col-md-12 p-5 ">
        <div class="row ">
            <div class="col-xl-3 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange1">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-user-plus"></i>

                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    Auteur
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange-dark1">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-user-cog"></i>

                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    Admin
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-object-group"></i>
                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    collection
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange1">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    location
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row ">
            <div class="col-xl-4 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="far fa-puzzle-piece"></i>
                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    Section
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange-dark1">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-books"></i>
                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    Type
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="#">
                    <div class="card l-bg-orange">

                        <div class="card-statistic-3 p-5">
                            <div class="card-icon card-icon-large">
                                <i class="far fa-question"></i>
                            </div>


                            <div class="mb-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus"></i>
                                    Statut
                                </h5>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
    </div>

    </div>
    <?php require_once("./footer.php"); ?>

    </div>

</body>

</html>