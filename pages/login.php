<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PolyPlex - Battle</title>

    <link rel="icon" type="image/x-icon" href="/polyplex/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/loginTest.css">
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
        <form class="login-form col-6 p-4 d-flex flex-column">
            <div class="mb-4">
                <label for="InputEmail1" class="form-label ubuntu-bold fs-5">Email</label>
                <input placeholder="example@email.com" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-5">
                <label for="InputPassword1" class="form-label ubuntu-bold fs-5">Password</label>
                <input placeholder="superSecret@here" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn login-submit-btn fs-4">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>