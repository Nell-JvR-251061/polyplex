<?php

if (session_status() === PHP_SESSION_NONE) { //start's session if their is no session active
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);

$isLoggedIn = isset($_SESSION['user_id']);
?>

<nav class="navbar navbar-expand-lg mt-3">
    <div class="container-fluid">

        <a class="navbar-brand logo-container d-flex justify-content-center" href="/polyplex/">
            <div class="logo d-flex">
                <span class="starfish-regular flipped d-flex align-items-center">P</span>
                <span class="starfish-regular d-flex align-items-center">P</span>
            </div>
        </a>

        <span class="nav-title starfish-regular ms-4 me-4">PolyPlex</span>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

            <div class="navbar-nav col-12 d-flex justify-content-around">

                <a class="nav-link nav-button ubuntu-bold p-2 <?= $currentPage == 'index.php' ? 'active' : '' ?>" href="/polyplex/"> HOME</a>

                <a class="nav-link nav-button ubuntu-bold p-2 <?= $currentPage == 'battle.php' ? 'active' : '' ?>" href="/polyplex/pages/battle.php"> BATTLE </a>

                <a class="nav-link nav-button ubuntu-bold p-2 <?= $currentPage == 'trade.php' ? 'active' : '' ?>" href="/polyplex/pages/trade.php"> TRADE </a>

                <?php if ($isLoggedIn && $currentPage === 'dashboard.php'): ?> <!-- if user is on the dashboard page, makes the logout button appear-->
                    <a class="nav-link nav-button ubuntu-bold p-2" href="/polyplex/components/logout.php"> LOG OUT </a>
                <?php else: ?>
                    <a class="nav-link nav-button profile-link ubuntu-bold p-2 d-flex justify-content-center" href="<?= $isLoggedIn ? '/polyplex/pages/dashboard.php' : '/polyplex/pages/login.php' ?>"> <?= htmlspecialchars($_SESSION['initial'] ?? '?') ?> </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>