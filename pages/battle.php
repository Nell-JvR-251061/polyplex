<?php
session_start();

require_once '../config/db.php';

// Check if user is not logged in, if not forces to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Check if user has a team
if (!isset($_SESSION['team_id'])) {
    die('No "I" in team...');
}

$teamId = $_SESSION['team_id']; //get's team id from session storage
//gets all three shapes from database via the team table
$sql = 'SELECT t.team_id, t.team_name, 
        s1.shape_id AS shape_a_id,
        s1.shape AS shape_a,
        s1.fill_colour AS fill_colour_a,
        s1.border_colour AS border_colour_a,
        s1.shape_level AS shape_level_a,
        a1.ability_name AS ability_name_a,
        a1.ability_description AS ability_description_a,
        a1.ability_modifier AS ability_modifier_a,
        a1.ability_target AS ability_target_a,

        s2.shape_id AS shape_b_id,
        s2.shape AS shape_b,
        s2.fill_colour AS fill_colour_b,
        s2.border_colour AS border_colour_b,
        s2.shape_level AS shape_level_b,
        a2.ability_name AS ability_name_b,
        a2.ability_description AS ability_description_b,
        a2.ability_modifier AS ability_modifier_b,
        a2.ability_target AS ability_target_b,

        s3.shape_id AS shape_c_id,
        s3.shape AS shape_c,
        s3.fill_colour AS fill_colour_c,
        s3.border_colour AS border_colour_c,
        s3.shape_level AS shape_level_c,
        a3.ability_name AS ability_name_c,
        a3.ability_description AS ability_description_c,
        a3.ability_modifier AS ability_modifier_c,
        a3.ability_target AS ability_target_c

    FROM teams t LEFT JOIN shapes s1 ON t.shape_a_id = s1.shape_id
    LEFT JOIN abilities a1 ON s1.shape_ability = a1.ability_id
    LEFT JOIN shapes s2 ON t.shape_b_id = s2.shape_id
    LEFT JOIN abilities a2 ON s2.shape_ability = a2.ability_id
    LEFT JOIN shapes s3 ON t.shape_c_id = s3.shape_id
    LEFT JOIN abilities a3 ON s3.shape_ability = a3.ability_id
    WHERE t.team_id = ?';

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database query failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $teamId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$team = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$team) {
    die("Team not found.");
}

$shapes = [];

foreach (['a', 'b', 'c'] as $position) {
    $shapes[] = [
        'shape_id' => $team["shape_{$position}_id"],
        'shape' => $team["shape_{$position}"],
        'fill_colour' => $team["fill_colour_{$position}"],
        'border_colour' => $team["border_colour_{$position}"],
        'shape_level' => $team["shape_level_{$position}"],

        'ability_name' => $team["ability_name_{$position}"],
        'ability_description' => $team["ability_description_{$position}"],
        'ability_modifier' => $team["ability_modifier_{$position}"],
        'ability_target' => $team["ability_target_{$position}"]
    ];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PolyPlex - Battle</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <link rel="stylesheet" href="../styling/battle.css">
</head>

<body>

    <header>
        <?php include '../components/nav.php'; ?>
    </header>

    <div class="container-fluid mt-4">

        <div class="row d-flex justify-content-between ms-2 me-2">

            <div class="col-6 battle-left text-center">


                <div class="row">
                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold">
                        <?= htmlspecialchars($team['team_name']) ?>
                    </span>
                </div>

                <div class="row" id="team-shapes">

                    <?php foreach ($shapes as $index => $shape): ?>

                        <?php
                        $shapeId = $shape['shape_id'];
                        $shapeDB = strtolower(trim($shape['shape']));

                        $fillColour = $shape['fill_colour'] ?? "#FFFFFF";
                        $strokeColour = $shape['border_colour'] ?? "#000000";

                        $shapeLevel = $shape['shape_level'] ?? 1;

                        $abilityName = $shape['ability_name'] ?? "None";
                        $abilityDescription = $shape['ability_description'] ?? "";
                        $abilityModifier = $shape['ability_modifier'] ?? "+";
                        $abilityTarget = $shape['ability_target'] ?? "self";

                        $position = $index + 1;
                        ?>

                        <div
                            class="col m-2 shape-position"
                            data-shape-id="<?= htmlspecialchars($shapeId) ?>">

                            <div class="shape-container">

                                <?php include '../components/shapeCard.php'; ?>

                            </div>

                            <div class="dropdown dropdown-center my-4 text-center ubuntu-regular">
                                <button
                                    class="btn dropdown-toggle fs-4 position-button"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Position <?= $position ?>
                                </button>
                                <ul class="dropdown-menu mx-auto">
                                    <li>
                                        <button
                                            class="dropdown-item position-option"
                                            type="button"
                                            data-position="1">
                                            Position 1
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item position-option"
                                            type="button"
                                            data-position="2">
                                            Position 2
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item position-option"
                                            type="button"
                                            data-position="3">
                                            Position 3
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


            <div class="col-5 battle-right">

                <div class="row">

                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold text-center">
                        Opponent
                    </span>

                </div>

                <div class="row opponent-box text-center d-flex align-items-center my-2">

                    <span class="ubuntu-bold">
                        ?
                    </span>

                </div>

            </div>

        </div>

    </div>


    <div class="col-12 d-flex justify-content-center">

        <button class="btn col-6 fight-btn fs-1 text-center ubuntu-bold">
            FIGHT!
        </button>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const container = document.getElementById('team-shapes');

            if (!container) {
                console.error('team-shapes container not found');
                return;
            }

            // Handle position selection
            container.addEventListener('click', function(event) {

                const option = event.target.closest('.position-option');

                if (!option) {
                    return;
                }

                const selectedPosition = parseInt(
                    option.getAttribute('data-position'),
                    10
                );

                const currentColumn = option.closest('.shape-position');

                if (!currentColumn) {
                    return;
                }

                const columns = Array.from(
                    container.querySelectorAll('.shape-position')
                );

                const currentIndex = columns.indexOf(currentColumn);
                const targetIndex = selectedPosition - 1;

                // Already in that position
                if (currentIndex === targetIndex) {
                    return;
                }

                const targetColumn = columns[targetIndex];

                if (!targetColumn) {
                    return;
                }

                const currentNextSibling = currentColumn.nextSibling;

                if (currentIndex < targetIndex) {

                    container.insertBefore(
                        targetColumn,
                        currentColumn
                    );
                } else {
                    container.insertBefore(
                        currentColumn,
                        targetColumn
                    );
                }
                updatePositionButtons();

            });


            function updatePositionButtons() {

                const columns = Array.from(
                    container.querySelectorAll('.shape-position')
                );

                columns.forEach(function(column, index) {

                    const position = index + 1;

                    const button = column.querySelector('.position-button');

                    if (button) {
                        button.textContent = 'Position ' + position;
                    }

                });
            }
        });
    </script>

</body>

</html>