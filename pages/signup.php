<?php
session_start();

require_once '../config/db.php';
require_once '../components/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $userName = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo json_encode([
            'success' => false,
            'error' => 'Passwords do not match.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'error' => 'Please enter a valid email address.'
        ]);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode([
            'success' => false,
            'error' => 'Password must be at least 8 characters.',
        ]);
        exit;
    }

    $sql = "SELECT user_id FROM users WHERE email = ? OR user_name = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {

        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $conn->error
        ]);

        exit;
    }

    $stmt->bind_param(
        "ss",
        $email,
        $userName
    );

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        echo json_encode([
            'success' => false,
            'error' => 'That email or username is already in use.'
        ]);

        exit;
    }

    $stmt->close();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn->begin_transaction();

        $sql = "INSERT INTO users
            (name, surname, user_name, email, password_hash, user_team)
            VALUES (?, ?, ?, ?, ?, NULL)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception(
                'Could not prepare user creation: ' . $conn->error
            );
        }

        $stmt->bind_param(
            "sssss",
            $name,
            $surname,
            $userName,
            $email,
            $passwordHash
        );

        if (!$stmt->execute()) {
            throw new Exception(
                'Could not create account: ' . $stmt->error
            );
        }

        $newUserId = $conn->insert_id;

        $stmt->close();

        $shapeAId = CreateShape();

        if ($shapeAId === false) {
            throw new Exception('Could not create shape A.');
        }


        $shapeBId = CreateShape();

        if ($shapeBId === false) {
            throw new Exception('Could not create shape B.');
        }


        $shapeCId = CreateShape();

        if ($shapeCId === false) {
            throw new Exception('Could not create shape C.');
        }

        $teamName = $userName . "'s Team";

        $sql = "INSERT INTO teams
            (team_name, shape_a_id, shape_b_id, shape_c_id)
            VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception(
                'Could not prepare team creation: ' . $conn->error
            );
        }

        $stmt->bind_param(
            "siii",
            $teamName,
            $shapeAId,
            $shapeBId,
            $shapeCId
        );

        if (!$stmt->execute()) {
            throw new Exception(
                'Could not create team: ' . $stmt->error
            );
        }

        $newTeamId = $conn->insert_id;

        $stmt->close();

        $sql = "UPDATE users
            SET user_team = ?
            WHERE user_id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception(
                'Could not prepare user/team relationship: ' . $conn->error
            );
        }

        $stmt->bind_param(
            "ii",
            $newTeamId,
            $newUserId
        );

        if (!$stmt->execute()) {
            throw new Exception(
                'Could not assign team to user: ' . $stmt->error
            );
        }

        $stmt->close();

        $conn->commit();

        session_regenerate_id(true);

        $_SESSION['user_id'] = $newUserId;
        $_SESSION['user_name'] = $userName;
        $_SESSION['email'] = $email;
        $_SESSION['initial'] = mb_substr(
            $userName,
            0,
            1,
            'UTF-8'
        );
        $_SESSION['team_id'] = $newTeamId;


        echo json_encode([
            'success' => true,
            'message' => 'Account created successfully!'
        ]);

        exit;
    } catch (Exception $e) {
        $conn->rollback();

        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);

        exit;
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
    <link rel="stylesheet" href="../styling/signup.css">
</head>

<header>
    <?php include '../components/nav.php'; ?>
</header>

<body>
    <div class="login-title col-12 text-center fs-1 ubuntu-bold my-5 p-2">
        <span class="col-12 text-center">
            SIGN-UP
        </span>
    </div>

    <div class="form-container d-flex justify-content-center">
        <form id="signupForm" class="login-form col-8 p-4 d-flex flex-column">
            <div id="signupError" class="alert alert-danger d-none"></div>
            <div class="row">
                <div class="col">
                    <div class="col mb-4">
                        <label for="InputName" class="form-label ubuntu-bold fs-5">Name</label>
                        <input placeholder="Pablo" type="text" name="name" class="form-control" id="InputName" required>
                    </div>
                    <div class="mb-4">
                        <label for="InputEmail" class="form-label ubuntu-bold fs-5">Email</label>
                        <input placeholder="example@email.com" type="email" name="email" class="form-control" id="InputEmail" required>
                    </div>
                    <div class="mb-5">
                        <label for="InputPassword" class="form-label ubuntu-bold fs-5">Password</label>
                        <input placeholder="superSecret@here" type="password" name="password" class="form-control" id="InputPassword" required>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-4">
                        <label for="InputSurname" class="form-label ubuntu-bold fs-5">Surname</label>
                        <input placeholder="Picasso" type="text" name="surname" class="form-control" id="InputSurname" required>
                    </div>
                    <div class="mb-4">
                        <label for="InputUsername" class="form-label ubuntu-bold fs-5">Username</label>
                        <input placeholder="Father of Cubism" type="text" name="username" class="form-control" id="InputUsername" required>
                    </div>
                    <div class="mb-5">
                        <label for="InputConfirmPassword" class="form-label ubuntu-bold fs-5">Confirm Password</label>
                        <input placeholder="superSecret@here.again" type="password" name="confirmPassword" class="form-control" id="InputConfirmPassword" required>
                    </div>
                </div>
            </div>
            <button type="submit" name="signup" class="btn col-5 login-submit-btn mx-auto fs-4">Let me in!</button>

            <span class="sign-up-link-text text-center mt-5">Already have an account? <a href="./login.php" class="sign-up-link ms-1"> Log in here </a> </span>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        document.getElementById('signupForm').addEventListener('submit', async function(event) {

            event.preventDefault();

            const errorBox = document.getElementById('signupError');
            const formData = new FormData(this);

            errorBox.classList.add('d-none');

            try {

                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (!result.success) {

                    errorBox.classList.remove('alert-success');
                    errorBox.classList.add('alert-danger');

                    errorBox.textContent = result.error;
                    errorBox.classList.remove('d-none');

                    return;
                }

                errorBox.classList.remove('alert-danger');
                errorBox.classList.add('alert-success');

                errorBox.textContent = result.message;
                errorBox.classList.remove('d-none');

                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1000);

            } catch (error) {

                console.error(error);

                errorBox.classList.remove('alert-success');
                errorBox.classList.add('alert-danger');

                errorBox.textContent = 'Something went wrong. Please try again.';
                errorBox.classList.remove('d-none');
            }

        });
    </script>
</body>

</html>