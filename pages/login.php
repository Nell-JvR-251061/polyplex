<?php
session_start();

require_once '../config/db.php';
require_once '../components/functions.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT user_id, email, user_name, password_hash, user_team FROM users WHERE email = ?';

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "s",
        $email
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {

            // Login successful

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['initial'] = mb_substr($user['user_name'], 0, 1, 'UTF-8');
            $_SESSION['team_id'] = $user['user_team'];


            header("Location: dashboard.php");
            exit;
        } else {

            $error = "Invalid email or password.";
        }
    } else {

        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Battle</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/login.css">
</head>

<header>
    <?php include '../components/nav.php'; ?>
</header>

<body>
    <div class="login-title col-12 text-center fs-1 ubuntu-bold my-5 p-2">
        <span class="col-12 text-center">
            LOGIN
        </span>
    </div>

    <div class="form-container d-flex justify-content-center">
        <form class="login-form col-6 p-4 d-flex flex-column" method="POST">
            <div class="mb-4">
                <label for="InputEmail" class="form-label ubuntu-bold fs-5">Email</label>
                <input placeholder="example@email.com" type="email" name="email" class="form-control" id="InputEmail" required>
            </div>
            <div class="mb-5">
                <label for="InputPassword" class="form-label ubuntu-bold fs-5">Password</label>
                <input placeholder="superSecret@here" type="password" name="password" class="form-control" id="InputPassword" required>
            </div>
            <button type="submit" name="login" class="btn login-submit-btn fs-4">Let's go!</button>

            <span class="sign-up-link-text text-center mt-5">Don't have an account? <a href="./signup.php" class="sign-up-link ms-1"> Sign up here </a> </span>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>