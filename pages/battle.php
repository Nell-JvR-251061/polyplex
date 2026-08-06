<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Battle</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/battle.css">
</head>

<header>
    <?php include '../components/nav.php'; ?>
</header>

<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-between ms-2 me-2">
            <div class="col-6 battle-left text-center">
                <div class="row">
                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold">Jupiter's Spartans</span>
                </div>
                <div class="row">
                    <div class="col m-2">
                        <div class="row">
                            <?php include '../components/shapeCard.php'; ?>
                        </div>
                        <div class="row">
                            <div class="dropdown my-4">
                                <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Positions 1
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Positions 1</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 2</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 3</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col m-2">
                        <div class="row">
                            <?php include '../components/shapeCard.php'; ?>
                        </div>
                        <div class="row">
                            <div class="dropdown my-4">
                                <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Positions 1
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Positions 1</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 2</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 3</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col m-2">
                        <div class="row">
                            <?php include '../components/shapeCard.php'; ?>
                        </div>
                        <div class="row">
                            <div class="dropdown my-4">
                                <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Positions 1
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Positions 1</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 2</a></li>
                                    <li><a class="dropdown-item" href="#">Positions 3</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-5 battle-right">
                <div class="row">
                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold text-center">Opponent</span>
                </div>
                <div class="row opponent-box text-center d-flex align-items-center my-2">
                    <span class="ubuntu-bold">?</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-center">
        <button class="btn col-6 fight-btn fs-1 text-center ubuntu-bold" type="button">
            FIGHT!
        </button>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>