<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Trade</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/trade.css">
</head>

<header>
    <?php include '../components/nav.php'; ?>
</header>

<body>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="dropdown d-flex justify-content-center">
                    <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Shape
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Circle</a></li>
                        <li><a class="dropdown-item" href="#">Triangle</a></li>
                        <li><a class="dropdown-item" href="#">Square</a></li>
                        <li><a class="dropdown-item" href="#">Pentagon</a></li>
                        <li><a class="dropdown-item" href="#">Hexagon</a></li>
                    </ul>
                </div>
            </div>
            <div class="col d-flex justify-content-center">
                <div class="dropdown d-flex justify-content-center">
                    <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Level
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">1</a></li>
                        <li><a class="dropdown-item" href="#">2</a></li>
                        <li><a class="dropdown-item" href="#">3</a></li>
                        <li><a class="dropdown-item" href="#">4</a></li>
                        <li><a class="dropdown-item" href="#">5</a></li>
                        <li><a class="dropdown-item" href="#">6</a></li>
                        <li><a class="dropdown-item" href="#">7</a></li>
                        <li><a class="dropdown-item" href="#">8</a></li>
                        <li><a class="dropdown-item" href="#">9</a></li>
                        <li><a class="dropdown-item" href="#">10</a></li>
                    </ul>
                </div>
            </div>
            <div class="col d-flex justify-content-center">
                <div class="dropdown p2">
                    <button class="btn dropdown-toggle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Abilities
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Anchor</a></li>
                        <li><a class="dropdown-item" href="#">Pierce</a></li>
                        <li><a class="dropdown-item" href="#">Overgrowth</a></li>
                        <li><a class="dropdown-item" href="#">Shockwave</a></li>
                        <li><a class="dropdown-item" href="#">Blood Pact</a></li>
                        <li><a class="dropdown-item" href="#">Void Step</a></li>
                        <li><a class="dropdown-item" href="#">Evasive</a></li>
                        <li><a class="dropdown-item" href="#">Iron Will</a></li>
                        <li><a class="dropdown-item" href="#">Overclock</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php
        for ($i = 0; $i < 3; $i++) {
            echo '<div class="row my-4">';

            for ($j = 0; $j < 5; $j++) {
                echo '<div class="col">';

                include '../components/shapeCard.php';

                echo '</div>';
            }

            echo '</div>';
        }
        ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>