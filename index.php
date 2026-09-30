<?php
require 'config.php';
if(isset($_SESSION['user'])) { header('Location:dashboard.php'); exit; }
$err = '';
if($_POST) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $s = $pdo->prepare('SELECT * FROM tb_login WHERE username=? AND password=?');
    $s->execute([$u,$p]);
    if($r = $s->fetch()) {
        $_SESSION['user'] = $r['username'];
        header('Location:dashboard.php');
        exit;
    } else {
        $err = 'Username atau Password salah';
    }
}
?>
<!doctype html>
<html lang='id' data-theme='light'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width,initial-scale=1'>
    <title>Login - POSYANDU Kemuning XII</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>
    <link rel='stylesheet' href='assets/css/custom.css'>
    <script>(function(){ const t=localStorage.getItem('posyandu-theme')||'light'; document.documentElement.setAttribute('data-theme',t); })();</script>
</head>
<body>
<div id="page-transition"></div>

<!-- Dark mode toggle on login page -->
<div style="position:fixed;top:16px;right:16px;z-index:1000;">
    <button id="darkModeToggle" title="Toggle Dark Mode">
        <i class="fa fa-moon"></i><span>Gelap</span>
    </button>
</div>

<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <i class="fa fa-heartbeat"></i>
        </div>
        <h4 class='mb-1 fw-bold text-center' style="color:var(--text-primary)">POSYANDU</h4>
        <p class='text-center mb-4' style="color:var(--text-muted);font-size:0.85rem;">Kemuning XII — Sistem Informasi Kesehatan</p>

        <?php if($err): ?>
        <div class='alert alert-danger d-flex align-items-center gap-2'>
            <i class="fa fa-exclamation-circle"></i>
            <span><?= $err ?></span>
        </div>
        <?php endif; ?>

        <form method='post'>
            <div class='mb-3'>
                <label class='form-label'><i class="fa fa-user me-1"></i>Username</label>
                <input name='username' class='form-control' placeholder="Masukkan username" required autofocus>
            </div>
            <div class='mb-4'>
                <label class='form-label'><i class="fa fa-lock me-1"></i>Password</label>
                <div class="input-group">
                    <input type='password' name='password' id='pwInput' class='form-control' placeholder="Masukkan password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw()" style="border-radius:0 8px 8px 0;border-left:none;">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button class='btn btn-primary w-100 py-2'>
                <i class='fa fa-sign-in-alt me-2'></i>Masuk
            </button>
        </form>

        <div class='mt-3 text-center' style="font-size:0.8rem;color:var(--text-muted);">
            Default: <span style="font-family:monospace;color:var(--accent)">posyandu</span> / <span style="font-family:monospace;color:var(--accent)">posyandu123</span>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
<script>
function togglePw() {
    const pw = document.getElementById('pwInput');
    const icon = document.getElementById('eyeIcon');
    if (pw.type === 'password') { pw.type = 'text'; icon.className = 'fa fa-eye-slash'; }
    else { pw.type = 'password'; icon.className = 'fa fa-eye'; }
}
function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem('posyandu-theme', t);
    const btn = document.getElementById('darkModeToggle');
    const i = btn.querySelector('i'); const s = btn.querySelector('span');
    i.className = t === 'dark' ? 'fa fa-sun' : 'fa fa-moon';
    s.textContent = t === 'dark' ? 'Terang' : 'Gelap';
}
document.addEventListener('DOMContentLoaded', () => {
    applyTheme(localStorage.getItem('posyandu-theme') || 'light');
    document.getElementById('darkModeToggle').addEventListener('click', () => {
        applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#')) return;
        link.addEventListener('click', e => {
            e.preventDefault();
            document.getElementById('page-transition').classList.add('active');
            setTimeout(() => { window.location.href = href; }, 350);
        });
    });
});
</script>
</body>
</html>
