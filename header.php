<?php if(!isset($_SESSION))session_start(); ?>
<!doctype html>
<html lang='id' data-theme='light'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title><?= isset($title)?$title.' - ':'' ?>POSYANDU Kemuning XII</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>
    <link rel='stylesheet' href='assets/css/custom.css'>
</head>
<body>

<!-- Page Transition -->
<div id="page-transition"></div>

<!-- Scroll to top -->
<button id="scrollTopBtn" title="Ke atas"><i class="fa fa-chevron-up"></i></button>

<nav class='navbar navbar-expand-lg navbar-dark'>
    <div class='container-fluid px-3'>
        <a class='navbar-brand' href='dashboard.php'>
            <i class='fa fa-heartbeat'></i>POSYANDU
        </a>
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button id="darkModeToggleMobile" title="Toggle Dark Mode" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:white;border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.9rem;">
                <i class="fa fa-moon"></i>
            </button>
            <button class='navbar-toggler border-0' data-bs-toggle='collapse' data-bs-target='#nav' aria-controls='nav' aria-expanded='false'>
                <span class='navbar-toggler-icon'></span>
            </button>
        </div>
        <div class='collapse navbar-collapse' id='nav'>
            <?php if(isset($_SESSION['user'])): ?>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='beranda'?'active':'' ?>' href='dashboard.php'>
                        <i class='fa fa-home me-1'></i>Beranda
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='balita'?'active':'' ?>' href='balita.php'>
                        <i class='fa fa-baby me-1'></i>Data Balita
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='lansia'?'active':'' ?>' href='lansia.php'>
                        <i class='fa fa-user-clock me-1'></i>Data Lansia
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='ibu_hamil'?'active':'' ?>' href='ibu_hamil.php'>
                        <i class='fa fa-female me-1'></i>Ibu Hamil
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='input'?'active':'' ?>' href='input.php'>
                        <i class='fa fa-notes-medical me-1'></i>Input Data
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='hasil'?'active':'' ?>' href='hasil_pemeriksaan.php'>
                        <i class='fa fa-clipboard-list me-1'></i>Hasil Periksa
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link <?= ($active??'')==='tentang'?'active':'' ?>' href='tentang.php'>
                        <i class='fa fa-info-circle me-1'></i>Tentang
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                <span class='navbar-text small'>
                    <i class='fa fa-user-circle me-1'></i><?= htmlspecialchars($_SESSION['user']) ?>
                </span>
                <a href='logout.php' class='btn btn-outline-light btn-sm'>
                    <i class="fa fa-sign-out-alt me-1"></i>Keluar
                </a>
                <button id="darkModeToggle" title="Toggle Dark Mode" class="d-none d-lg-flex">
                    <i class="fa fa-moon"></i><span>Gelap</span>
                </button>
            </div>
            <?php else: ?>
            <div class="ms-auto d-flex">
                <button id="darkModeToggle" title="Toggle Dark Mode">
                    <i class="fa fa-moon"></i><span>Gelap</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class='container-fluid px-3 px-md-4' style="max-width:1400px;margin:0 auto;">
<div class="page-enter">

<script>
// Dark mode - apply immediately to prevent flash
(function(){
    const saved = localStorage.getItem('posyandu-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    // Update icon once DOM loads
    window._savedTheme = saved;
})();
</script>
