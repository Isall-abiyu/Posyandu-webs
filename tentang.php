<?php
$title='Tentang Posyandu';
$active='tentang';
require 'config.php';
require 'auth.php';
include 'header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h3 class="text-primary"><i class='fa fa-heartbeat me-2'></i>Tentang Posyandu</h3>
    <p style="color:var(--text-secondary)">Posyandu (Pos Pelayanan Terpadu) merupakan wadah pelayanan kesehatan dasar, termasuk pelayanan kesehatan ibu dan anak, imunisasi, gizi, dan kesehatan lansia yang dilaksanakan oleh dan untuk masyarakat.</p>

    <h5 class="mt-4" style="color:var(--text-primary)">Visi</h5>
    <p style="color:var(--text-secondary)"><em>"Mewujudkan masyarakat sehat dan mandiri melalui pelayanan kesehatan terpadu."</em></p>

    <h5 class="mt-4" style="color:var(--text-primary)">Misi</h5>
    <ul style="color:var(--text-secondary)">
      <li>Meningkatkan derajat kesehatan balita melalui pemantauan rutin</li>
      <li>Memelihara kesehatan lansia dengan pemeriksaan berkala</li>
      <li>Meningkatkan pengetahuan masyarakat tentang kesehatan</li>
      <li>Sebagai pusat informasi kesehatan masyarakat</li>
    </ul>

    <h5 class="mt-4" style="color:var(--text-primary)">Layanan Posyandu</h5>
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <div class="card border-primary h-100">
          <div class="card-body">
            <h6 class="text-primary"><i class="fa fa-baby me-2"></i>Posyandu Balita</h6>
            <ul class="small mb-0" style="color:var(--text-secondary)">
              <li>Penimbangan berat badan dan tinggi badan</li>
              <li>Pemantauan status gizi</li>
              <li>Imunisasi dasar</li>
              <li>Konseling gizi dan ASI</li>
              <li>Vitamin A dan obat cacing</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card border-success h-100">
          <div class="card-body">
            <h6 class="text-success"><i class="fa fa-user-clock me-2"></i>Posyandu Lansia</h6>
            <ul class="small mb-0" style="color:var(--text-secondary)">
              <li>Pemeriksaan tekanan darah</li>
              <li>Pemeriksaan gula darah</li>
              <li>Penimbangan berat badan dan tinggi badan</li>
              <li>Konseling kesehatan lansia</li>
              <li>Senam lansia dan kegiatan sosial</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <h5 class="mt-4" style="color:var(--text-primary)">Struktur Pengurus</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr style="background:rgba(13,110,253,0.1)">
            <th style="color:var(--accent)">Jabatan</th>
            <th style="color:var(--accent)">Nama</th>
            <th style="color:var(--accent)">Kontak</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Ketua</td><td>Ibu Siti Aminah</td><td>0857-XXXX-XXXX</td></tr>
          <tr><td>Sekretaris</td><td>Ibu Rina Wijaya</td><td>0812-XXXX-XXXX</td></tr>
          <tr><td>Bendahara</td><td>Ibu Mariana</td><td>0821-XXXX-XXXX</td></tr>
          <tr><td>Kader Kesehatan</td><td>Ibu Ratna, Ibu Dewi</td><td>0853-XXXX-XXXX</td></tr>
          <tr><td>Kader Lansia</td><td>Ibu Sumiati, Ibu Hartini</td><td>0856-XXXX-XXXX</td></tr>
        </tbody>
      </table>
    </div>

    <h5 class="mt-4" style="color:var(--text-primary)">FAQ</h5>
    <div class="accordion" id="faq">
      <div class="accordion-item">
        <h2 class="accordion-header" id="f1">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c1">Kapan jadwal kegiatan Posyandu Balita?</button>
        </h2>
        <div id="c1" class="accordion-collapse collapse" data-bs-parent="#faq">
          <div class="accordion-body">Setiap Rabu minggu ke-2, pukul 08.00–11.00 WIB.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="f2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c2">Kapan jadwal kegiatan Posyandu Lansia?</button>
        </h2>
        <div id="c2" class="accordion-collapse collapse" data-bs-parent="#faq">
          <div class="accordion-body">Setiap Jumat minggu ke-4, pukul 08.00–11.00 WIB.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="f3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c3">Apakah Posyandu menyediakan layanan imunisasi?</button>
        </h2>
        <div id="c3" class="accordion-collapse collapse" data-bs-parent="#faq">
          <div class="accordion-body">Ya, bekerja sama dengan Puskesmas setempat.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="f4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c4">Apa saja pemeriksaan untuk lansia?</button>
        </h2>
        <div id="c4" class="accordion-collapse collapse" data-bs-parent="#faq">
          <div class="accordion-body">Pemeriksaan meliputi tekanan darah, gula darah, berat badan, tinggi badan, dan konsultasi kesehatan.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="f5">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c5">Bagaimana cara mengakses data kesehatan?</button>
        </h2>
        <div id="c5" class="accordion-collapse collapse" data-bs-parent="#faq">
          <div class="accordion-body">Hubungi kader Posyandu dengan menunjukkan identitas untuk verifikasi.</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
