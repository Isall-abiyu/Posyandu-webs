</div><!-- end page-enter -->
</div><!-- end container -->

<footer>
    <div class="d-flex align-items-center justify-content-center gap-2">
        <i class="fa fa-heartbeat text-danger"></i>
        <span>&copy; <?= date('Y') ?> Aplikasi Posyandu Kemuning XII — Sehat Bersama</span>
    </div>
</footer>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
<script>
// ===================== DARK MODE =====================
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('posyandu-theme', theme);
    const isDark = theme === 'dark';
    const icon = isDark ? 'fa-sun' : 'fa-moon';
    const label = isDark ? 'Terang' : 'Gelap';
    document.querySelectorAll('#darkModeToggle, #darkModeToggleMobile').forEach(btn => {
        if (!btn) return;
        const i = btn.querySelector('i');
        const span = btn.querySelector('span');
        if (i) { i.className = `fa ${icon}`; }
        if (span) span.textContent = label;
        if (!span && btn.id === 'darkModeToggleMobile') {
            if (i) i.className = `fa ${icon}`;
        }
    });
}

// Apply saved theme icon on load
document.addEventListener('DOMContentLoaded', function() {
    const saved = localStorage.getItem('posyandu-theme') || 'light';
    applyTheme(saved);

    ['darkModeToggle','darkModeToggleMobile'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', function() {
            const current = document.documentElement.getAttribute('data-theme');
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    });
});

// ===================== PAGE TRANSITION =====================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript') ||
            href.startsWith('mailto') || link.target === '_blank' ||
            href.includes('action=delete')) return;
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const overlay = document.getElementById('page-transition');
            overlay.classList.add('active');
            setTimeout(() => { window.location.href = href; }, 350);
        });
    });
});

// ===================== SCROLL TO TOP =====================
const scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', function() {
    if (window.scrollY > 300) scrollBtn.classList.add('visible');
    else scrollBtn.classList.remove('visible');
});
scrollBtn.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

// ===================== AUTO-DISMISS ALERTS =====================
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        if (alert && alert.parentNode) {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
});

// ===================== TABLE ROW ANIMATION =====================
document.querySelectorAll('tbody tr').forEach((row, i) => {
    row.style.animationDelay = `${i * 0.04}s`;
    row.style.animation = 'fadeSlideIn 0.4s ease both';
});

// ===================== TABLE SCROLL HINT =====================
document.querySelectorAll('.table-responsive').forEach(el => {
    el.addEventListener('scroll', function() {
        this.classList.add('scrolled');
    }, { once: true });
});
</script>
</body>
</html>
