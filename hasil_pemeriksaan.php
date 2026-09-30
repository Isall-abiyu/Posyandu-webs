<?php
$title='Hasil Pemeriksaan';
$active='hasil';
require 'config.php';
require 'auth.php';
include 'header.php';

$balita = $pdo->query('SELECT * FROM tb_balita ORDER BY tgl_periksa DESC')->fetchAll();
$lansia = $pdo->query('SELECT * FROM tb_lansia ORDER BY tgl_periksa DESC')->fetchAll();
$hamil  = $pdo->query('SELECT k.*, i.nama, i.nik, i.status_risiko FROM tb_kunjungan_hamil k JOIN tb_ibu_hamil i ON k.id_ibu=i.id ORDER BY k.tgl_periksa DESC')->fetchAll();
?>

<h3 class='mb-4'><i class='fa fa-clipboard-list me-2'></i>Hasil Pemeriksaan</h3>

<ul class='nav nav-tabs mb-4' id='hasilTabs' role='tablist'>
    <li class='nav-item' role='presentation'>
        <button class='nav-link active' id='hasil-balita-tab' data-bs-toggle='tab' data-bs-target='#hasil-balita' type='button' role='tab'>
            <i class='fa fa-baby me-1'></i>Balita <span class='badge bg-primary'><?= count($balita) ?></span>
        </button>
    </li>
    <li class='nav-item' role='presentation'>
        <button class='nav-link' id='hasil-lansia-tab' data-bs-toggle='tab' data-bs-target='#hasil-lansia' type='button' role='tab'>
            <i class='fa fa-user-clock me-1'></i>Lansia <span class='badge bg-success'><?= count($lansia) ?></span>
        </button>
    </li>
    <li class='nav-item' role='presentation'>
        <button class='nav-link' id='hasil-hamil-tab' data-bs-toggle='tab' data-bs-target='#hasil-hamil' type='button' role='tab'>
            <i class='fa fa-female me-1'></i>Ibu Hamil <span class='badge bg-danger'><?= count($hamil) ?></span>
        </button>
    </li>
</ul>

<div class='tab-content' id='hasilTabsContent'>
    <!-- Hasil Balita -->
    <div class='tab-pane fade show active' id='hasil-balita' role='tabpanel'>
        <div class='card shadow-sm'>
            <div class='card-body'>
            <div class='table-responsive'>
                <?php if(count($balita) == 0): ?>
                    <p class='text-center text-muted py-4'>Belum ada data pemeriksaan balita</p>
                <?php else: ?>
                <table class='table table-striped table-hover align-middle'>
                    <thead class='posyandu-thead-primary'>
                        <tr>
                            <th>No</th>
                            <th>No. Daftar</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur (bln)</th>
                            <th>BB (Kg)</th>
                            <th>TB (Cm)</th>
                            <th>Status Gizi</th>
                            <th>Tanggal Periksa</th>
                            <th>Nama Ibu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($balita as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['id'] ?></td>
                            <td><?= htmlspecialchars($d['nik']) ?></td>
                            <td><?= htmlspecialchars($d['nama']) ?></td>
                            <td><?= $d['jenis_kelamin']=='L'?'Laki-laki':'Perempuan' ?></td>
                            <td><?= $d['umur_bulan'] ?></td>
                            <td><?= $d['bb_kg'] ?></td>
                            <td><?= $d['tb_cm'] ?></td>
                            <td>
                                <span class='badge bg-<?= $d['status_gizi']=='Normal'?'success':($d['status_gizi']=='Kurang'?'warning text-dark':'danger') ?>'>
                                    <?= $d['status_gizi'] ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($d['tgl_periksa'])) ?></td>
                            <td><?= htmlspecialchars($d['nama_ibu'] ?? '') ?></td>
                            <td>
                                <a href='balita.php?action=edit&id=<?= $d['id'] ?>' class='btn btn-sm btn-outline-primary' title='Edit'><i class='fa fa-edit'></i></a>
                                <a href='balita.php?action=delete&id=<?= $d['id'] ?>' class='btn btn-sm btn-outline-danger' title='Hapus' onclick="return confirm('Hapus data ini?')"><i class='fa fa-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div><!-- /table-responsive -->
            </div><!-- /card-body -->
        </div><!-- /card -->
    </div><!-- /tab-pane balita -->

    <!-- Hasil Lansia -->
    <div class='tab-pane fade' id='hasil-lansia' role='tabpanel'>
        <div class='card shadow-sm'>
            <div class='card-body'>
            <div class='table-responsive'>
                <?php if(count($lansia) == 0): ?>
                    <p class='text-center text-muted py-4'>Belum ada data pemeriksaan lansia</p>
                <?php else: ?>
                <table class='table table-striped table-hover align-middle'>
                    <thead class='posyandu-thead-success'>
                        <tr>
                            <th>No</th>
                            <th>No. Daftar</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur (thn)</th>
                            <th>BB (Kg)</th>
                            <th>TB (Cm)</th>
                            <th>Tekanan Darah</th>
                            <th>Gula Darah</th>
                            <th>Tanggal Periksa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($lansia as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['id'] ?></td>
                            <td><?= htmlspecialchars($d['nik']) ?></td>
                            <td><?= htmlspecialchars($d['nama']) ?></td>
                            <td><?= $d['jenis_kelamin']=='L'?'Laki-laki':'Perempuan' ?></td>
                            <td><?= $d['umur'] ?></td>
                            <td><?= $d['bb_kg'] ?></td>
                            <td><?= $d['tb_cm'] ?></td>
                            <td>
                                <?php
                                $td_val = $d['tekanan_darah'];
                                $td_parts = explode('/', $td_val);
                                $td_class = 'bg-success';
                                if (count($td_parts) == 2) {
                                    $sys = (int)$td_parts[0];
                                    if ($sys >= 140 || (int)$td_parts[1] >= 90) $td_class = 'bg-danger';
                                    elseif ($sys >= 130 || (int)$td_parts[1] >= 85) $td_class = 'bg-warning text-dark';
                                }
                                ?>
                                <span class='badge <?= $td_class ?>'><?= htmlspecialchars($td_val) ?></span>
                            </td>
                            <td>
                                <?php
                                $gd = (float)$d['gula_darah'];
                                $gd_class = 'bg-success';
                                if ($gd > 200) $gd_class = 'bg-danger';
                                elseif ($gd > 140) $gd_class = 'bg-warning text-dark';
                                ?>
                                <span class='badge <?= $gd_class ?>'><?= $d['gula_darah'] ?> mg/dL</span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($d['tgl_periksa'])) ?></td>
                            <td>
                                <a href='lansia.php?action=edit&id=<?= $d['id'] ?>' class='btn btn-sm btn-outline-primary' title='Edit'><i class='fa fa-edit'></i></a>
                                <a href='lansia.php?action=delete&id=<?= $d['id'] ?>' class='btn btn-sm btn-outline-danger' title='Hapus' onclick="return confirm('Hapus data ini?')"><i class='fa fa-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div><!-- /table-responsive -->
            </div><!-- /card-body -->
        </div><!-- /card -->
    </div><!-- /tab-pane lansia -->

    <!-- Hasil Ibu Hamil -->
    <div class='tab-pane fade' id='hasil-hamil' role='tabpanel'>
        <div class='card shadow-sm'>
            <div class='card-body p-0'>
            <div class='table-responsive'>
                <?php if(count($hamil) == 0): ?>
                    <p class='text-center text-muted py-4'>Belum ada data kunjungan ibu hamil</p>
                <?php else: ?>
                <table class='table table-striped table-hover align-middle'>
                    <thead class='posyandu-thead-primary' style="--accent-head:#dc3545">
                        <tr>
                            <th>No</th><th>Tgl Periksa</th><th>NIK</th><th>Nama Ibu</th>
                            <th>Usia Keh.</th><th>BB</th><th>TD</th><th>TFU</th>
                            <th>DJJ</th><th>Edema</th><th>Hb</th><th>Status Risiko</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($hamil as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($d['tgl_periksa'])) ?></td>
                            <td><?= htmlspecialchars($d['nik']) ?></td>
                            <td><strong><?= htmlspecialchars($d['nama']) ?></strong></td>
                            <td><span class='badge bg-primary'><?= $d['usia_kehamilan_minggu'] ?> mgg</span></td>
                            <td><?= $d['bb_kg'] ?> kg</td>
                            <td><?php
                                $td=$d['tekanan_darah']; $p=explode('/',$td); $tc='bg-success';
                                if(count($p)==2){$s=(int)$p[0];if($s>=140||(int)$p[1]>=90)$tc='bg-danger';elseif($s>=130||(int)$p[1]>=85)$tc='bg-warning text-dark';}
                            ?><span class='badge <?= $tc ?>'><?= htmlspecialchars($td) ?></span></td>
                            <td><?= $d['tfu_cm'] ?> cm</td>
                            <td><?= $d['djj'] ?> dpm</td>
                            <td><?php $ec=['Tidak'=>'success','Ringan'=>'warning','Sedang'=>'warning','Berat'=>'danger']; $e=$d['edema']??'Tidak'; ?>
                                <span class='badge bg-<?= $ec[$e]??'secondary' ?> <?= $e!=='Tidak'?'text-dark':'' ?>'><?= $e ?></span></td>
                            <td><?php $hb=(float)$d['hb']; ?><span class='badge bg-<?= $hb>=11?'success':'danger' ?>'><?= $d['hb'] ?></span></td>
                            <td><?php $rc=['Normal'=>'success','Risiko Rendah'=>'warning','Risiko Tinggi'=>'danger']; $r=$d['status_risiko']??'Normal'; ?>
                                <span class='badge bg-<?= $rc[$r]??'secondary' ?>'><?= $r ?></span></td>
                            <td><a href='ibu_hamil.php?view=<?= $d['id_ibu'] ?>' class='btn btn-sm btn-outline-danger' title='Detail'><i class='fa fa-eye'></i></a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div><!-- /table-responsive -->
            </div><!-- /card-body -->
        </div><!-- /card -->
    </div><!-- /tab-pane hamil -->
</div><!-- /tab-content -->

<?php include 'footer.php'; ?>
