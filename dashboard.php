<?php
$title='Beranda';
$active='beranda';
require 'config.php';
require 'auth.php';

$cnt_balita  = $pdo->query('SELECT COUNT(*) FROM tb_balita')->fetchColumn();
$cnt_lansia  = $pdo->query('SELECT COUNT(*) FROM tb_lansia')->fetchColumn();
$cnt_hamil   = $pdo->query('SELECT COUNT(*) FROM tb_ibu_hamil WHERE aktif=1')->fetchColumn();
$last_balita = $pdo->query('SELECT nama, tgl_periksa FROM tb_balita ORDER BY tgl_periksa DESC LIMIT 1')->fetch();
$last_lansia = $pdo->query('SELECT nama, tgl_periksa FROM tb_lansia ORDER BY tgl_periksa DESC LIMIT 1')->fetch();
$last_hamil  = $pdo->query('SELECT i.nama, k.tgl_periksa FROM tb_kunjungan_hamil k JOIN tb_ibu_hamil i ON k.id_ibu=i.id ORDER BY k.tgl_periksa DESC LIMIT 1')->fetch();

include 'header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h2 class='mb-1 fw-bold'>
            <i class="fa fa-hand-wave me-2 text-warning"></i>
            Selamat datang, <span class='text-primary'><?= htmlspecialchars($_SESSION['user']) ?></span>!
        </h2>
        <p style="color:var(--text-muted);font-size:0.9rem;margin:0">
            <i class="fa fa-calendar me-1"></i><?= date('l, d F Y') ?> — Posyandu Kemuning XII
        </p>
    </div>
</div>

<!-- Stats Row -->
<div class='row g-3 mb-4'>
    <div class='col-6 col-md-3 page-enter-delay-1'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-primary'><i class='fa fa-baby'></i></div>
            <div class='stat-number text-primary'><?= $cnt_balita ?></div>
            <div class='stat-label'>Total Balita</div>
        </div>
    </div>
    <div class='col-6 col-md-3 page-enter-delay-1'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-success'><i class='fa fa-user-clock'></i></div>
            <div class='stat-number text-success'><?= $cnt_lansia ?></div>
            <div class='stat-label'>Total Lansia</div>
        </div>
    </div>
    <div class='col-6 col-md-3 page-enter-delay-1'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-danger'><i class='fa fa-female'></i></div>
            <div class='stat-number text-danger'><?= $cnt_hamil ?></div>
            <div class='stat-label'>Ibu Hamil Aktif</div>
        </div>
    </div>
    <div class='col-6 col-md-3 page-enter-delay-2'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-info'><i class='fa fa-stethoscope'></i></div>
            <div style="font-size:0.8rem;font-weight:700;color:var(--text-secondary);margin-bottom:4px">Periksa Balita Terakhir</div>
            <?php if($last_balita): ?>
                <div style="font-size:0.95rem;font-weight:700;color:var(--text-primary)"><?= htmlspecialchars($last_balita['nama']) ?></div>
                <div style="font-size:0.75rem;color:var(--text-muted)"><?= date('d/m/Y',strtotime($last_balita['tgl_periksa'])) ?></div>
            <?php else: ?><div style="color:var(--text-muted);font-size:0.85rem">Belum ada data</div><?php endif; ?>
        </div>
    </div>
    <div class='col-6 col-md-3 page-enter-delay-2'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-warning'><i class='fa fa-stethoscope'></i></div>
            <div style="font-size:0.8rem;font-weight:700;color:var(--text-secondary);margin-bottom:4px">Periksa Lansia Terakhir</div>
            <?php if($last_lansia): ?>
                <div style="font-size:0.95rem;font-weight:700;color:var(--text-primary)"><?= htmlspecialchars($last_lansia['nama']) ?></div>
                <div style="font-size:0.75rem;color:var(--text-muted)"><?= date('d/m/Y',strtotime($last_lansia['tgl_periksa'])) ?></div>
            <?php else: ?><div style="color:var(--text-muted);font-size:0.85rem">Belum ada data</div><?php endif; ?>
        </div>
    </div>
    <div class='col-6 col-md-3 page-enter-delay-2'>
        <div class='stat-card shadow-sm'>
            <div class='stat-icon text-danger'><i class='fa fa-stethoscope'></i></div>
            <div style="font-size:0.8rem;font-weight:700;color:var(--text-secondary);margin-bottom:4px">Periksa Ibu Hamil Terakhir</div>
            <?php if($last_hamil): ?>
                <div style="font-size:0.95rem;font-weight:700;color:var(--text-primary)"><?= htmlspecialchars($last_hamil['nama']) ?></div>
                <div style="font-size:0.75rem;color:var(--text-muted)"><?= date('d/m/Y',strtotime($last_hamil['tgl_periksa'])) ?></div>
            <?php else: ?><div style="color:var(--text-muted);font-size:0.85rem">Belum ada data</div><?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card page-enter-delay-2" style="border-left:4px solid var(--accent)">
            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                <span style="font-weight:700;color:var(--text-secondary);font-size:0.85rem;margin-right:4px"><i class="fa fa-bolt me-1"></i>Akses Cepat:</span>
                <a href="balita.php?action=add" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Tambah Balita</a>
                <a href="lansia.php?action=add" class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i>Tambah Lansia</a>
                <a href="ibu_hamil.php" class="btn btn-danger btn-sm"><i class="fa fa-female me-1"></i>Ibu Hamil</a>
                <a href="input.php" class="btn btn-outline-primary btn-sm"><i class="fa fa-notes-medical me-1"></i>Input Data</a>
                <a href="hasil_pemeriksaan.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-clipboard-list me-1"></i>Lihat Hasil</a>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal & Info -->
<div class='row g-3 mb-4'>
    <div class='col-md-6 page-enter-delay-2'>
        <div class='card h-100' style="border-left:4px solid #0d6efd">
            <div class='card-body'>
                <h5 class='text-primary mb-3'><i class='fa fa-baby me-2'></i>Jadwal Posyandu Balita</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-primary"><i class="fa fa-calendar-week"></i></span><span>Minggu ke-2, <strong>Hari Rabu</strong></span></div>
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-primary"><i class="fa fa-clock"></i></span><span>Pukul <strong>08.00 – 11.00 WIB</strong></span></div>
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-primary"><i class="fa fa-map-marker-alt"></i></span><span>Posyandu Kemuning XII</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-6 page-enter-delay-3'>
        <div class='card h-100' style="border-left:4px solid #198754">
            <div class='card-body'>
                <h5 class='text-success mb-3'><i class='fa fa-user-clock me-2'></i>Jadwal Posyandu Lansia</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-success"><i class="fa fa-calendar-week"></i></span><span>Minggu ke-4, <strong>Hari Jumat</strong></span></div>
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-success"><i class="fa fa-clock"></i></span><span>Pukul <strong>08.00 – 11.00 WIB</strong></span></div>
                    <div class="d-flex align-items-center gap-2"><span class="badge bg-success"><i class="fa fa-map-marker-alt"></i></span><span>Posyandu Kemuning XII</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='row g-3 mb-2'>
    <div class='col-md-6 page-enter-delay-3'>
        <div class='card h-100' style="border-left:4px solid #ffc107">
            <div class='card-body'>
                <h5 style="color:#856404"><i class='fa fa-exclamation-triangle me-2'></i>Informasi Penting</h5>
                <ul class='small mb-0' style="color:var(--text-secondary);padding-left:1.2rem;line-height:2">
                    <li>Bawa KMS / Buku KIA</li>
                    <li>Bawa alat tulis jika diperlukan</li>
                    <li>Pastikan anak dalam kondisi sehat</li>
                    <li>Lansia diharapkan puasa sebelum cek gula darah</li>
                    <li>Gunakan masker &amp; protokol kesehatan</li>
                    <li>Datang tepat waktu</li>
                </ul>
            </div>
        </div>
    </div>
    <div class='col-md-6 page-enter-delay-3'>
        <div class='card h-100'>
            <div class='card-body'>
                <h5 style="color:var(--text-secondary)"><i class='fa fa-info-circle me-2'></i>Informasi Posyandu</h5>
                <p style="font-size:0.9rem;color:var(--text-secondary)">Posyandu adalah pelayanan kesehatan dasar yang dikelola dan diselenggarakan dari, oleh, untuk dan bersama masyarakat dalam penyelenggaraan pembangunan kesehatan.</p>
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex align-items-center gap-2"><i class="fa fa-map-marker-alt text-danger"></i><span style="font-size:0.85rem">RT 03/RW 08</span></div>
                    <div class="d-flex align-items-center gap-2"><i class="fa fa-phone text-success"></i><span style="font-size:0.85rem">Ibu Ratna (0821-XXXX-XXXX)</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
