<?php

session_start();

require_once '../config/db.php';
require_once '../components/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

//update team name
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_team_name'])) {

    $teamName = trim($_POST['team_name'] ?? '');

    if ($teamName === '') {
        die("Please enter a team name");
    }

    $sql = "UPDATE teams t INNER JOIN users u ON u.user_team = t.team_id SET t.team_name = ? WHERE u.user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Database update failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $teamName,
        $userId
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("Team name update failed... " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);

    header("Location: dashboard.php"); //reload to display new name
    exit();
}

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

        FROM users u INNER JOIN teams t ON u.user_team = t.team_id
        LEFT JOIN shapes s1 ON t.shape_a_id = s1.shape_id
        LEFT JOIN abilities a1 ON s1.shape_ability = a1.ability_id
        LEFT JOIN shapes s2 ON t.shape_b_id = s2.shape_id
        LEFT JOIN abilities a2 ON s2.shape_ability = a2.ability_id
        LEFT JOIN shapes s3 ON t.shape_c_id = s3.shape_id
        LEFT JOIN abilities a3 ON s3.shape_ability = a3.ability_id
        WHERE u.user_id = ?';


$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Query failed..." . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $userId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$team = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$team) {
    die("You do not have a team assigned.");
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

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>PolyPlex - Dashboard</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <link rel="stylesheet" href="../styling/dashboard.css">
</head>


<body>
    <header>
        <?php include '../components/nav.php'; ?>
    </header>

    <div class="user-banner text-center my-4 fs-1 ubuntu-bold">
        <span>
            Welcome back <?= htmlspecialchars($_SESSION['user_name']) ?>
        </span>
    </div>


    <div class="container-fluid">
        <div class="row d-flex justify-content-between ms-2 me-2">
            <div class="col-6 battle-left text-center">
                <div class="row justify-content-center my-3">
                    <form method="POST" class="d-flex justify-content-center align-items-center gap-2 ubuntu-regular">

                        <input type="text" name="team_name" class="form-control team-name-input fs-2 ubuntu-bold text-center" value="<?= htmlspecialchars($team['team_name']) ?>" maxlength="50" required>

                        <button type="submit" name="update_team_name" class="btn save-team-btn fs-4">
                            Save
                        </button>

                    </form>

                </div>

                <div class="row" id="team-shapes">
                    <?php foreach ($shapes as $shape): ?>
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
                        ?>


                        <div class="col m-2 shape-position" data-shape-id="<?= htmlspecialchars($shapeId) ?>">
                            <div class="shape-container">
                                <?php
                                include '../components/shapeCard.php';
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-5 battle-right">
                <div class="row">
                    <span class="battle-title my-3 p-1 fs-2 ubuntu-bold text-center">
                        Statistics
                    </span>
                </div>
                <div class="row stat-container p-2">
                    <div class="col fs-3 ubuntu-bold">
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span>Wins </span>
                            </div>

                            <div class="col text-center">
                                <span> 12 </span>
                            </div>

                        </div>

                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span> Loss </span>
                            </div>

                            <div class="col text-center">
                                <span> 7 </span>
                            </div>
                        </div>

                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span> MW % </span>
                            </div>

                            <div class="col text-center">
                                <span> 63.16 </span>
                            </div>
                        </div>

                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span> OMW % </span>
                            </div>

                            <div class="col text-center">
                                <span> 54.32 </span>
                            </div>
                        </div>
                        <div class="row stat-row mb-2">
                            <div class="col">
                                <span> Win Streak </span>
                            </div>

                            <div class="col text-center">
                                <span> 2 </span>
                            </div>
                        </div>

                        <div class="row stat-row">

                            <div class="col">
                                <span> Shapes Traded </span>
                            </div>

                            <div class="col text-center">
                                <span> 5 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwxHj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>
</body>

</html>