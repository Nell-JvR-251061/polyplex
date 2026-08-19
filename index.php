<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Home</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./styling/index.css">
</head>

<header>
    <?php include './components/nav.php'; ?>
</header>

<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col ms-5 me-5 index-left p-3">
                <div class="row pt-2 ps-5">
                    <svg class="index-square" viewBox="0 0 24 24">
                        <rect x="2" y="2" width="20" height="20" />
                    </svg>
                </div>
                <div class="row d-flex justify-content-end pe-5">
                    <svg class="index-circle" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                </div>
                <div class="row d-flex justify-content-center">
                    <svg class="index-triangle" viewBox="-1 -1 26 26">
                        <polygon points="12,2 22,22 2,22" />
                    </svg>
                </div>
            </div>
            <div class="col ms-5 me-5 index-right d-flex flex-column">
                <span class="index-tag-line mb-3 ubuntu-bold text-center">It's time to fight!</span>
                <span class="index-info-text inter-regular">Welcome to PolyPlex, a fast-paced auto battler where unique shapes become powerful fighters.
                    Build your squad, trade shapes with other players, and discover new strategies in a constantly
                    evolving world. Every season lasts just one week, after which all shapes reset, giving everyone
                    a fresh start and a new chance to climb the leaderboard. Adapt quickly, trade wisely, and prove
                    your strategy before time runs out.</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>