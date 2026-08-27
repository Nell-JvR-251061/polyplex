<?php

session_start();

require_once '../config/db.php';
require_once '../components/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['perform_trade'])
) {

    header('Content-Type: application/json');

    $newShapeId = filter_input(
        INPUT_POST,
        'new_shape_id',
        FILTER_VALIDATE_INT
    );

    $oldShapeId = filter_input(
        INPUT_POST,
        'old_shape_id',
        FILTER_VALIDATE_INT
    );

    if (!$newShapeId || !$oldShapeId) {

        echo json_encode([
            'success' => false,
            'error' => 'Invalid shape selection.'
        ]);

        exit();
    }


    if ($newShapeId === $oldShapeId) {

        echo json_encode([
            'success' => false,
            'error' => 'You cannot trade a shape for itself.'
        ]);

        exit();
    }

    mysqli_begin_transaction($conn);


    try {

        $sql = "
            SELECT
                team_id,
                team_name,
                shape_a_id,
                shape_b_id,
                shape_c_id

            FROM teams

            INNER JOIN users
                ON users.user_team = teams.team_id

            WHERE users.user_id = ?

            FOR UPDATE
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare team query."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $userId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $team = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);


        if (!$team) {

            throw new Exception(
                "You do not have a team."
            );
        }
        $oldShapePosition = null;


        if (
            (int)$team['shape_a_id'] === $oldShapeId
        ) {

            $oldShapePosition = 'a';
        } elseif (
            (int)$team['shape_b_id'] === $oldShapeId
        ) {

            $oldShapePosition = 'b';
        } elseif (
            (int)$team['shape_c_id'] === $oldShapeId
        ) {

            $oldShapePosition = 'c';
        }


        if ($oldShapePosition === null) {

            throw new Exception(
                "The shape you are trying to trade is not on your team."
            );
        }

        $sql = "
            SELECT
                shape_id,
                shape_level,
                trading

            FROM shapes

            WHERE shape_id = ?

            FOR UPDATE
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare old shape query."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $oldShapeId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $oldShape = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);


        if (!$oldShape) {

            throw new Exception(
                "Your shape could not be found."
            );
        }

        $sql = "
            SELECT
                shape_id,
                shape_level,
                trading

            FROM shapes

            WHERE shape_id = ?

            FOR UPDATE
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare new shape query."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $newShapeId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $newShape = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);


        if (!$newShape) {

            throw new Exception(
                "The selected shape could not be found."
            );
        }

        if ((int)$newShape['trading'] !== 1) {

            throw new Exception(
                "This shape is no longer available for trading."
            );
        }

        if (
            (int)$oldShape['shape_level']
            !==
            (int)$newShape['shape_level']
        ) {

            throw new Exception(
                "You can only trade shapes of the same level."
            );
        }

        if (
            (int)$team['shape_a_id'] === $newShapeId
            ||
            (int)$team['shape_b_id'] === $newShapeId
            ||
            (int)$team['shape_c_id'] === $newShapeId
        ) {

            throw new Exception(
                "You already have this shape on your team."
            );
        }

        $sql = "
            UPDATE shapes

            SET trading = 1

            WHERE shape_id = ?
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare old shape update."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $oldShapeId
        );

        if (!mysqli_stmt_execute($stmt)) {

            throw new Exception(
                "Could not update old shape."
            );
        }

        mysqli_stmt_close($stmt);

        $sql = "
            UPDATE shapes

            SET trading = 0

            WHERE shape_id = ?
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare new shape update."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $newShapeId
        );

        if (!mysqli_stmt_execute($stmt)) {

            throw new Exception(
                "Could not update new shape."
            );
        }

        mysqli_stmt_close($stmt);

        $column = "shape_{$oldShapePosition}_id";

        $sql = "
            UPDATE teams

            SET {$column} = ?

            WHERE team_id = ?
        ";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            throw new Exception(
                "Could not prepare team update."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $newShapeId,
            $team['team_id']
        );

        if (!mysqli_stmt_execute($stmt)) {

            throw new Exception(
                "Could not update team."
            );
        }

        mysqli_stmt_close($stmt);

        mysqli_commit($conn);


        echo json_encode([
            'success' => true,
            'message' => 'Trade completed successfully.'
        ]);

        exit();
    } catch (Exception $e) {

        mysqli_rollback($conn);


        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);

        exit();
    }
}

$sql = "
    SELECT
        t.team_id,
        t.team_name,
        t.shape_a_id,
        t.shape_b_id,
        t.shape_c_id

    FROM teams t

    INNER JOIN users u
        ON u.user_team = t.team_id

    WHERE u.user_id = ?
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database query failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$team = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$team) {
    die("You do not have a team assigned.");
}

$userShapeIds = [
    $team['shape_a_id'],
    $team['shape_b_id'],
    $team['shape_c_id']
];

$userShapeIds = array_map(
    'intval',
    $userShapeIds
);

$userShapes = [];

foreach ($userShapeIds as $shapeId) {

    $sql = "
        SELECT
            s.shape_id,
            s.shape,
            s.border_colour,
            s.fill_colour,
            s.shape_level,
            s.trading,

            a.ability_id,
            a.ability_name,
            a.ability_description,
            a.ability_modifier,
            a.ability_target

        FROM shapes s

        LEFT JOIN abilities a
            ON s.shape_ability = a.ability_id

        WHERE s.shape_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Shape query failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $shapeId
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $userShape = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);


    if ($userShape) {

        $userShapes[] = $userShape;
    }
}


$sql = "
    SELECT
        s.shape_id,
        s.shape,
        s.border_colour,
        s.fill_colour,
        s.shape_level,
        s.trading,

        a.ability_id,
        a.ability_name,
        a.ability_description,
        a.ability_modifier,
        a.ability_target

    FROM shapes s

    LEFT JOIN abilities a
        ON s.shape_ability = a.ability_id

    WHERE s.trading = 1

    ORDER BY s.shape_id ASC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: "
        . mysqli_error($conn));
}

$shapes = mysqli_fetch_all(
    $result,
    MYSQLI_ASSOC
);

$abilitySql = "
    SELECT
        ability_id,
        ability_name

    FROM abilities

    ORDER BY ability_name ASC
";

$abilityResult = mysqli_query(
    $conn,
    $abilitySql
);

if (!$abilityResult) {
    die("Ability query failed: "
        . mysqli_error($conn));
}

$abilities = mysqli_fetch_all(
    $abilityResult,
    MYSQLI_ASSOC
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge">

    <title>PolyPlex - Trade</title>

    <link
        rel="icon"
        type="image/x-icon"
        href="/polyplex/assets/favicon.ico">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../styling/trade.css">

</head>


<body>

    <header>

        <?php include '../components/nav.php'; ?>

    </header>

    <div class="container-fluid my-5">

        <div class="row">

            <div class="col d-flex justify-content-center">

                <div class="dropdown dropdown-center px-2">

                    <button
                        id="shape-filter-button"
                        class="btn dropdown-toggle fs-4"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Shape

                    </button>


                    <ul class="dropdown-menu">

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="all">

                                All Shapes

                            </button>

                        </li>

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="circle">

                                Circle

                            </button>

                        </li>

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="triangle">

                                Triangle

                            </button>

                        </li>

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="square">

                                Square

                            </button>

                        </li>

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="pentagon">

                                Pentagon

                            </button>

                        </li>

                        <li>

                            <button
                                class="dropdown-item shape-filter"
                                type="button"
                                data-value="hexagon">

                                Hexagon

                            </button>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="col d-flex justify-content-center">

                <div class="dropdown dropdown-center px-2">

                    <button
                        id="level-filter-button"
                        class="btn dropdown-toggle fs-4"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Level

                    </button>


                    <ul class="dropdown-menu">

                        <li>

                            <button
                                class="dropdown-item level-filter"
                                type="button"
                                data-value="all">

                                All Levels

                            </button>

                        </li>


                        <?php for ($level = 1; $level <= 10; $level++): ?>

                            <li>

                                <button
                                    class="dropdown-item level-filter"
                                    type="button"
                                    data-value="<?= $level ?>">

                                    Level <?= $level ?>

                                </button>

                            </li>

                        <?php endfor; ?>

                    </ul>

                </div>

            </div>

            <div class="col d-flex justify-content-center">

                <div class="dropdown dropdown-center px-2">

                    <button
                        id="ability-filter-button"
                        class="btn dropdown-toggle fs-4"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Ability

                    </button>


                    <ul class="dropdown-menu">

                        <li>

                            <button
                                class="dropdown-item ability-filter"
                                type="button"
                                data-value="all">

                                All Abilities

                            </button>

                        </li>


                        <?php foreach ($abilities as $ability): ?>

                            <li>

                                <button
                                    class="dropdown-item ability-filter"
                                    type="button"
                                    data-value="<?= htmlspecialchars(
                                                    (string)$ability['ability_id']
                                                ) ?>">

                                    <?= htmlspecialchars(
                                        $ability['ability_name']
                                    ) ?>

                                </button>

                            </li>

                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div
            class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4"
            id="shape-list">


            <?php if (empty($shapes)): ?>

                <div class="col-12 text-center">

                    <p class="fs-4">

                        No shapes are currently available
                        for trading.

                    </p>

                </div>


            <?php else: ?>


                <?php foreach ($shapes as $shape): ?>

                    <?php

                    $shapeId =
                        $shape['shape_id'];

                    $shapeDB =
                        strtolower(
                            trim(
                                $shape['shape']
                            )
                        );

                    $fillColour =
                        $shape['fill_colour']
                        ?? '#FFFFFF';

                    $strokeColour =
                        $shape['border_colour']
                        ?? '#000000';

                    $shapeLevel =
                        $shape['shape_level']
                        ?? 1;

                    $abilityId =
                        $shape['ability_id']
                        ?? '';

                    $abilityName =
                        $shape['ability_name']
                        ?? 'None';

                    $abilityDescription =
                        $shape['ability_description']
                        ?? '';

                    $abilityModifier =
                        $shape['ability_modifier']
                        ?? '+';

                    $abilityTarget =
                        $shape['ability_target']
                        ?? 'self';

                    ?>

                    <div
                        class="col shape-item"

                        data-shape="<?= htmlspecialchars(
                                        $shapeDB
                                    ) ?>"

                        data-level="<?= htmlspecialchars(
                                        (string)$shapeLevel
                                    ) ?>"

                        data-ability="<?= htmlspecialchars(
                                            (string)$abilityId
                                        ) ?>"

                        data-shape-id="<?= htmlspecialchars(
                                            (string)$shapeId
                                        ) ?>">

                        <div
                            class="trade-shape-card"
                            role="button"
                            tabindex="0"
                            data-bs-toggle="modal"
                            data-bs-target="#tradeModal"
                            data-shape-id="<?= htmlspecialchars(
                                                (string)$shapeId
                                            ) ?>"
                            data-shape-name="<?= htmlspecialchars(
                                                    $shape['shape']
                                                ) ?>"
                            data-shape-level="<?= htmlspecialchars(
                                                    (string)$shapeLevel
                                                ) ?>">

                            <?php

                            include '../components/shapeCard.php';

                            ?>

                        </div>


                    </div>


                <?php endforeach; ?>


            <?php endif; ?>


        </div>


        <div
            id="no-results"
            class="text-center fs-4 mt-4"
            style="display: none;">

            No shapes match your filters.

        </div>

    </div>

    <div
        class="modal fade"
        id="tradeModal"
        tabindex="-1"
        aria-labelledby="tradeModalLabel"
        aria-hidden="true">


        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1
                        class="modal-title fs-3 ubuntu-bold"
                        id="tradeModalLabel">
                        Trade Shape
                    </h1>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="text-center">

                        <p class="fs-4 ubuntu-bold">

                            Choose one of your shapes
                            to trade for it:

                        </p>

                    </div>
                    <div
                        id="user-shapes"
                        class="row g-3 mt-2">


                        <?php foreach ($userShapes as $userShape): ?>

                            <?php

                            $userShapeId =
                                $userShape['shape_id'];

                            $userShapeName =
                                $userShape['shape'];

                            $userShapeLevel =
                                $userShape['shape_level'];

                            $shapeDB =
                                strtolower(
                                    trim(
                                        $userShape['shape']
                                    )
                                );

                            $fillColour =
                                $userShape['fill_colour']
                                ?? '#FFFFFF';

                            $strokeColour =
                                $userShape['border_colour']
                                ?? '#000000';

                            $shapeLevel =
                                $userShape['shape_level']
                                ?? 1;

                            $abilityName =
                                $userShape['ability_name']
                                ?? 'None';

                            $abilityDescription =
                                $userShape['ability_description']
                                ?? '';

                            $abilityModifier =
                                $userShape['ability_modifier']
                                ?? '+';

                            $abilityTarget =
                                $userShape['ability_target']
                                ?? 'self';

                            ?>


                            <div class="col-4">

                                <button
                                    type="button"
                                    class="btn w-100 user-shape-option p-2"

                                    data-old-shape-id="<?= htmlspecialchars(
                                                            (string)$userShapeId
                                                        ) ?>"

                                    data-old-shape-name="<?= htmlspecialchars(
                                                                $userShapeName
                                                            ) ?>"

                                    data-old-shape-level="<?= htmlspecialchars(
                                                                (string)$userShapeLevel
                                                            ) ?>">

                                    <div
                                        class="user-shape-card">

                                        <?php

                                        include '../components/shapeCard.php';

                                        ?>

                                    </div>

                                </button>

                            </div>


                        <?php endforeach; ?>


                    </div>

                    <div
                        id="tradeError"
                        class="alert alert-danger d-none mt-4">
                    </div>
                    <div
                        id="tradeSuccess"
                        class="alert alert-success d-none mt-4">
                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-between mx-5">

                    <button
                        type="button"
                        class="btn btn-secondary trade-modal-cancel-btn"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button
                        type="button"
                        id="confirmTradeButton"
                        class="btn btn-primary trade-modal-trade-btn"
                        disabled>

                        Trade

                    </button>

                </div>


            </div>

        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>


    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {
                const shapeItems =
                    document.querySelectorAll(
                        '.shape-item'
                    );

                const noResults =
                    document.getElementById(
                        'no-results'
                    );

                const shapeButton =
                    document.getElementById(
                        'shape-filter-button'
                    );

                const levelButton =
                    document.getElementById(
                        'level-filter-button'
                    );

                const abilityButton =
                    document.getElementById(
                        'ability-filter-button'
                    );

                let selectedShape = 'all';

                let selectedLevel = 'all';

                let selectedAbility = 'all';

                function filterShapes() {

                    let visibleCount = 0;


                    shapeItems.forEach(
                        function(item) {

                            const shape =
                                item.dataset.shape;

                            const level =
                                item.dataset.level;

                            const ability =
                                item.dataset.ability;


                            const shapeMatches =
                                selectedShape === 'all' ||
                                shape === selectedShape;


                            const levelMatches =
                                selectedLevel === 'all' ||
                                level === selectedLevel;


                            const abilityMatches =
                                selectedAbility === 'all' ||
                                ability === selectedAbility;


                            if (
                                shapeMatches &&
                                levelMatches &&
                                abilityMatches
                            ) {

                                item.style.display = '';

                                visibleCount++;

                            } else {

                                item.style.display = 'none';

                            }

                        }
                    );


                    noResults.style.display =
                        visibleCount === 0 ?
                        'block' :
                        'none';
                }

                document
                    .querySelectorAll(
                        '.shape-filter'
                    )
                    .forEach(
                        function(option) {

                            option.addEventListener(
                                'click',
                                function() {

                                    selectedShape =
                                        this.dataset.value;


                                    shapeButton.textContent =
                                        selectedShape === 'all' ?
                                        'Shape' :
                                        this.textContent.trim();


                                    filterShapes();

                                }
                            );

                        }
                    );

                document
                    .querySelectorAll(
                        '.level-filter'
                    )
                    .forEach(
                        function(option) {

                            option.addEventListener(
                                'click',
                                function() {

                                    selectedLevel =
                                        this.dataset.value;


                                    levelButton.textContent =
                                        selectedLevel === 'all' ?
                                        'Level' :
                                        this.textContent.trim();


                                    filterShapes();

                                }
                            );

                        }
                    );

                document
                    .querySelectorAll(
                        '.ability-filter'
                    )
                    .forEach(
                        function(option) {

                            option.addEventListener(
                                'click',
                                function() {

                                    selectedAbility =
                                        this.dataset.value;


                                    abilityButton.textContent =
                                        selectedAbility === 'all' ?
                                        'Ability' :
                                        this.textContent.trim();


                                    filterShapes();

                                }
                            );

                        }
                    );

                const tradeModal =
                    document.getElementById(
                        'tradeModal'
                    );

                const selectedShapeName =
                    document.getElementById(
                        'selectedShapeName'
                    );

                const selectedShapeLevel =
                    document.getElementById(
                        'selectedShapeLevel'
                    );

                const tradeError =
                    document.getElementById(
                        'tradeError'
                    );

                const tradeSuccess =
                    document.getElementById(
                        'tradeSuccess'
                    );

                const confirmTradeButton =
                    document.getElementById(
                        'confirmTradeButton'
                    );

                let selectedNewShapeId = null;

                let selectedNewShapeLevel = null;

                let selectedOldShapeId = null;

                let selectedOldShapeLevel = null;

                tradeModal.addEventListener(
                    'show.bs.modal',
                    function(event) {


                        const clickedCard =
                            event.relatedTarget;


                        if (!clickedCard) {
                            return;
                        }

                        selectedNewShapeId =
                            parseInt(
                                clickedCard.dataset.shapeId
                            );

                        selectedNewShapeLevel =
                            parseInt(
                                clickedCard.dataset.shapeLevel
                            );

                        selectedOldShapeId = null;

                        selectedOldShapeLevel = null;

                        confirmTradeButton.disabled = true;

                        tradeError.classList.add(
                            'd-none'
                        );

                        tradeSuccess.classList.add(
                            'd-none'
                        );


                        document
                            .querySelectorAll(
                                '.user-shape-option'
                            )
                            .forEach(
                                function(button) {

                                    button.classList.remove(
                                        'border',
                                        'border-primary'
                                    );

                                }
                            );

                    }
                );

                document
                    .querySelectorAll(
                        '.user-shape-option'
                    )
                    .forEach(
                        function(button) {

                            button.addEventListener(
                                'click',
                                function() {


                                    selectedOldShapeId =
                                        parseInt(
                                            this.dataset.oldShapeId
                                        );


                                    selectedOldShapeLevel =
                                        parseInt(
                                            this.dataset.oldShapeLevel
                                        );

                                    document
                                        .querySelectorAll(
                                            '.user-shape-option'
                                        )
                                        .forEach(
                                            function(otherButton) {

                                                otherButton.classList.remove(
                                                    'border',
                                                    'border-primary'
                                                );

                                            }
                                        );

                                    this.classList.add(
                                        'border',
                                        'border-primary'
                                    );

                                    if (
                                        selectedOldShapeLevel !==
                                        selectedNewShapeLevel
                                    ) {

                                        confirmTradeButton.disabled =
                                            true;


                                        tradeError.textContent =
                                            'Cannot trade. The shapes must be the same level.';


                                        tradeError.classList.remove(
                                            'd-none'
                                        );


                                        return;
                                    }

                                    tradeError.classList.add(
                                        'd-none'
                                    );


                                    confirmTradeButton.disabled =
                                        false;

                                }
                            );

                        }
                    );

                confirmTradeButton.addEventListener(
                    'click',
                    async function() {


                        if (
                            !selectedNewShapeId ||
                            !selectedOldShapeId
                        ) {

                            return;
                        }

                        if (
                            selectedNewShapeLevel !==
                            selectedOldShapeLevel
                        ) {

                            tradeError.textContent =
                                'Cannot trade. The shapes must be the same level.';

                            tradeError.classList.remove(
                                'd-none'
                            );

                            return;
                        }

                        confirmTradeButton.disabled =
                            true;

                        confirmTradeButton.textContent =
                            'Trading...';


                        tradeError.classList.add(
                            'd-none'
                        );

                        const formData =
                            new FormData();

                        formData.append(
                            'perform_trade',
                            '1'
                        );

                        formData.append(
                            'new_shape_id',
                            selectedNewShapeId
                        );

                        formData.append(
                            'old_shape_id',
                            selectedOldShapeId
                        );


                        try {

                            const response =
                                await fetch(
                                    'trade.php', {
                                        method: 'POST',
                                        body: formData
                                    }
                                );


                            const result =
                                await response.json();

                            if (!result.success) {

                                tradeError.textContent =
                                    result.error ||
                                    'Trade failed.';

                                tradeError.classList.remove(
                                    'd-none'
                                );


                                confirmTradeButton.disabled =
                                    false;

                                confirmTradeButton.textContent =
                                    'Trade';

                                return;
                            }

                            tradeSuccess.textContent =
                                result.message;


                            tradeSuccess.classList.remove(
                                'd-none'
                            );


                            confirmTradeButton.textContent =
                                'Trade Complete';

                            setTimeout(
                                function() {

                                    window.location.reload();

                                },
                                1000
                            );


                        } catch (error) {

                            console.error(error);


                            tradeError.textContent =
                                'Something went wrong while performing the trade.';


                            tradeError.classList.remove(
                                'd-none'
                            );


                            confirmTradeButton.disabled =
                                false;

                            confirmTradeButton.textContent =
                                'Trade';
                        }
                    }
                );
            }
        );
    </script>

</body>

</html>