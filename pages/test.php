<?php
require_once '../config/db.php';
require_once '../components/functions.php';

if (isset($_POST['run_create_shape_btn'])) {
    // CreateShape();
    // $check = FetchShape(4);
    // ConsoleLog($check->created_at);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PolyPlex - Test</title>

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

    <h2>This is a test page</h2>

    <form method="post">
        <button type="submit" name="run_create_shape_btn">Create shape</button>
    </form>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>

</body>

</html>