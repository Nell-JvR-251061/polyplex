<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Battle</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/dashboard.css">
</head>

<header>
    <?php include '../components/nav.php'; ?>
</header>

<body>
    <div class="user-banner text-center my-4 fs-1 ubuntu-bold">
        <span>Welcome back User</span>
    </div>

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
                        <div class="row">
                            <button type="button" class="btn trade-btn fs-3">Trade</button>
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
                        <div class="row">
                            <button type="button" class="btn trade-btn fs-3">Trade</button>
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
                        <div class="row">
                            <button type="button" class="btn trade-btn fs-3">Trade</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5 battle-right">
                <div class="row">
                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold text-center">Statistics</span>
                </div>
                <div class="row stat-container p-2">
                    <div class="col fs-3 ubuntu-bold">
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>Wins</span>
                            </div>
                            <div class="col text-center">
                                <span>12</span>
                            </div>
                        </div>
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>Loss</span>
                            </div>
                            <div class="col text-center">
                                <span>7</span>
                            </div>
                        </div>
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>MW %</span>
                            </div>
                            <div class="col text-center">
                                <span>63.16</span>
                            </div>
                        </div>
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>OMW %</span>
                            </div>
                            <div class="col text-center">
                                <span>54.32</span>
                            </div>
                        </div>
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>Win Streak</span>
                            </div>
                            <div class="col text-center">
                                <span>2</span>
                            </div>
                        </div>
                        <div class="row stat-row">
                            <div class="col">
                                <span>Shapes Traded</span>
                            </div>
                            <div class="col text-center">
                                <span>5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>