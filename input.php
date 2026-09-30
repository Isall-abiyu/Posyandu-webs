<?php
$title='Input Data Kesehatan';
$active='input';
require 'config.php';
require 'auth.php';
include 'header.php';
?>

<h3 class='mb-4'><i class='fa fa-notes-medical me-2'></i>Input Data Kesehatan</h3>

<ul class='nav nav-tabs mb-4' id='inputTabs' role='tablist'>
    <li class='nav-item' role='presentation'>
        <button class='nav-link active' id='balita-tab' data-bs-toggle='tab' data-bs-target='#balita' type='button' role='tab'>
            <i class='fa fa-baby me-1'></i>Balita
        </button>
    </li>
    <li class='nav-item' role='presentation'>
        <button class='nav-link' id='lansia-tab' data-bs-toggle='tab' data-bs-target='#lansia' type='button' role='tab'>
            <i class='fa fa-user-clock me-1'></i>Lansia
        </button>
    </li>
    <li class='nav-item' role='presentation'>
        <button class='nav-link' id='hamil-tab' data-bs-toggle='tab' data-bs-target='#hamil' type='button' role='tab'>
            <i class='fa fa-female me-1'></i>Ibu Hamil
        </button>
    </li>
</ul>

<div class='tab-content' id='inputTabsContent'>
    <!-- Tab Balita -->
    <div class='tab-pane fade show active' id='balita' role='tabpanel'>
        <div class='card shadow-sm border-primary'>
            <div class='card-header bg-primary text-white'>
                <h5 class='mb-0'><i class='fa fa-baby me-2'></i>Input Data Kesehatan Balita</h5>
            </div>
            <div class='card-body'>
                <form method='post' action='balita.php?action=save'>
                    <input type='hidden' name='id' value='0'>
                    <div class='row g-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>NIK</label>
                            <input name='nik' class='form-control' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Jenis Kelamin</label>
                            <select name='jenis_kelamin' class='form-select' required>
                                <option value='L'>Laki-laki</option>
                                <option value='P'>Perempuan</option>
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Nama Balita</label>
                            <input name='nama' class='form-control' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Nama Ibu</label>
                            <input name='nama_ibu' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Umur (bulan)</label>
                            <input type='number' name='umur' class='form-control' required min='0'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tanggal Periksa</label>
                            <input type='date' name='tgl_periksa' value='<?= date('Y-m-d') ?>' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Berat Badan (kg)</label>
                            <input type='number' step='0.1' name='bb' class='form-control' required min='0'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tinggi Badan (cm)</label>
                            <input type='number' step='0.1' name='tb' class='form-control' required min='0'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Status Gizi</label>
                            <select name='status' class='form-select'>
                                <option value='Normal'>Normal</option>
                                <option value='Kurang'>Kurang</option>
                                <option value='Lebih'>Lebih</option>
                            </select>
                        </div>
                        <div class='col-12 text-end'>
                            <button class='btn btn-secondary' type='reset'><i class='fa fa-undo me-1'></i>Reset</button>
                            <button class='btn btn-primary' type='submit'><i class='fa fa-save me-1'></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tab Lansia -->
    <div class='tab-pane fade' id='lansia' role='tabpanel'>
        <div class='card shadow-sm border-success'>
            <div class='card-header bg-success text-white'>
                <h5 class='mb-0'><i class='fa fa-user-clock me-2'></i>Input Data Kesehatan Lansia</h5>
            </div>
            <div class='card-body'>
                <form method='post' action='lansia.php?action=save'>
                    <input type='hidden' name='id' value='0'>
                    <div class='row g-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>NIK</label>
                            <input name='nik' class='form-control' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Jenis Kelamin</label>
                            <select name='jenis_kelamin' class='form-select' required>
                                <option value='L'>Laki-laki</option>
                                <option value='P'>Perempuan</option>
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Nama Lansia</label>
                            <input name='nama' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Umur (tahun)</label>
                            <input type='number' name='umur' class='form-control' required min='1'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tanggal Periksa</label>
                            <input type='date' name='tgl_periksa' value='<?= date('Y-m-d') ?>' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Berat Badan (kg)</label>
                            <input type='number' step='0.1' name='bb' class='form-control' required min='0'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tinggi Badan (cm)</label>
                            <input type='number' step='0.1' name='tb' class='form-control' required min='0'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tekanan Darah</label>
                            <input name='tekanan_darah' class='form-control' placeholder='Contoh: 120/80' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Gula Darah (mg/dL)</label>
                            <input type='number' step='0.1' name='gula_darah' class='form-control' required min='0'>
                        </div>
                        <div class='col-12 text-end'>
                            <button class='btn btn-secondary' type='reset'><i class='fa fa-undo me-1'></i>Reset</button>
                            <button class='btn btn-success' type='submit'><i class='fa fa-save me-1'></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Tab Ibu Hamil -->
    <div class='tab-pane fade' id='hamil' role='tabpanel'>
        <div class='card shadow-sm' style='border-color:#dc3545'>
            <div class='card-header' style='background:linear-gradient(135deg,#dc3545,#a71d2a);color:white'>
                <h5 class='mb-0'><i class='fa fa-female me-2'></i>Input Data Kunjungan Ibu Hamil</h5>
            </div>
            <div class='card-body'>
                <?php
                $ibu_options = $pdo->query('SELECT id, nama, nik FROM tb_ibu_hamil WHERE aktif=1 ORDER BY nama')->fetchAll();
                ?>
                <?php if(!$ibu_options): ?>
                <div class="alert alert-warning"><i class="fa fa-info-circle me-2"></i>Belum ada data ibu hamil terdaftar. <a href="ibu_hamil.php" class="alert-link">Tambah dulu di halaman Ibu Hamil</a>.</div>
                <?php else: ?>
                <form method='post' action='ibu_hamil.php?view='>
                    <div class='row g-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Ibu Hamil</label>
                            <select name='id_ibu' id='pilihIbu' class='form-select' required onchange="updateActionUrl(this)">
                                <option value=''>-- Pilih Ibu Hamil --</option>
                                <?php foreach($ibu_options as $ib): ?>
                                <option value='<?= $ib['id'] ?>'><?= htmlspecialchars($ib['nama']) ?> (<?= $ib['nik'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type='hidden' name='kid' value='0'>
                        <div class='col-md-3'>
                            <label class='form-label'>Tanggal Periksa</label>
                            <input type='date' name='tgl_periksa' value='<?= date('Y-m-d') ?>' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Usia Kehamilan (minggu)</label>
                            <input type='number' name='usia_kehamilan' class='form-control' min='1' max='42' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Berat Badan (kg)</label>
                            <input type='number' step='0.1' name='bb' class='form-control' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tinggi Badan (cm)</label>
                            <input type='number' step='0.1' name='tb' class='form-control'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tekanan Darah</label>
                            <input name='tekanan_darah' class='form-control' placeholder='120/80' required>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>TFU (cm)</label>
                            <input type='number' step='0.1' name='tfu' class='form-control'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>DJJ (dpm)</label>
                            <input type='number' name='djj' class='form-control' min='80' max='200'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Presentasi Janin</label>
                            <select name='presentasi' class='form-select'>
                                <?php foreach(['Kepala','Sungsang','Lintang','Miring','Belum Dapat Dinilai'] as $p): ?>
                                <option value='<?= $p ?>'><?= $p ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Edema</label>
                            <select name='edema' class='form-select'>
                                <?php foreach(['Tidak','Ringan','Sedang','Berat'] as $e): ?>
                                <option value='<?= $e ?>'><?= $e ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Hb (g/dL)</label>
                            <input type='number' step='0.1' name='hb' class='form-control'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Tablet Fe</label>
                            <input type='number' name='tablet_fe' class='form-control' value='30'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Imunisasi TT</label>
                            <select name='imunisasi_tt' class='form-select'>
                                <?php foreach(['-','TT1','TT2','TT3','TT4','TT5'] as $tt): ?>
                                <option value='<?= $tt ?>'><?= $tt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Vitamin / Suplemen</label>
                            <input name='vitamin' class='form-control' placeholder='Asam folat, Vitamin C, ...'>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Catatan</label>
                            <textarea name='catatan_kunjungan' class='form-control' rows='2'></textarea>
                        </div>
                        <div class='col-12 text-end'>
                            <button class='btn btn-secondary' type='reset'><i class='fa fa-undo me-1'></i>Reset</button>
                            <button class='btn btn-danger' type='submit' name='save_kunjungan'><i class='fa fa-save me-1'></i>Simpan Kunjungan</button>
                        </div>
                    </div>
                </form>
                <script>
                function updateActionUrl(sel){
                    const id = sel.value;
                    if(id) sel.closest('form').action = 'ibu_hamil.php?view='+id;
                }
                </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?><?php /* PATCH: Tab Ibu Hamil added via footer append — see actual replacement below */ ?>
