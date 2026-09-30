<?php
$title='Data Ibu Hamil';
$active='ibu_hamil';
require 'config.php';
require 'auth.php';

$msg = '';

// ===================== SAVE IBU HAMIL =====================
if(isset($_POST['save_ibu'])) {
    $d = $_POST;
    $hpl = !empty($d['hpht']) ? date('Y-m-d', strtotime($d['hpht'].' +280 days')) : null;
    if(!empty($d['id']) && $d['id'] > 0) {
        $s = $pdo->prepare('UPDATE tb_ibu_hamil SET nik=?,nama=?,tgl_lahir=?,umur=?,alamat=?,no_hp=?,nama_suami=?,golongan_darah=?,gravida=?,paritas=?,abortus=?,jumlah_anak_hidup=?,hpht=?,hpl=?,status_risiko=?,faktor_risiko=?,catatan=?,aktif=? WHERE id=?');
        $s->execute([$d['nik'],$d['nama'],$d['tgl_lahir'],$d['umur'],$d['alamat'],$d['no_hp'],$d['nama_suami'],$d['golongan_darah'],$d['gravida'],$d['paritas'],$d['abortus'],$d['jumlah_anak_hidup'],$d['hpht'],$hpl,$d['status_risiko'],$d['faktor_risiko'],$d['catatan'],$d['aktif'],$d['id']]);
        $msg = 'success|Data ibu hamil berhasil diperbarui.';
    } else {
        $s = $pdo->prepare('INSERT INTO tb_ibu_hamil (nik,nama,tgl_lahir,umur,alamat,no_hp,nama_suami,golongan_darah,gravida,paritas,abortus,jumlah_anak_hidup,hpht,hpl,status_risiko,faktor_risiko,catatan,tgl_daftar,aktif) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)');
        $s->execute([$d['nik'],$d['nama'],$d['tgl_lahir'],$d['umur'],$d['alamat'],$d['no_hp'],$d['nama_suami'],$d['golongan_darah'],$d['gravida'],$d['paritas'],$d['abortus'],$d['jumlah_anak_hidup'],$d['hpht'],$hpl,$d['status_risiko'],$d['faktor_risiko'],$d['catatan'],date('Y-m-d')]);
        $msg = 'success|Data ibu hamil berhasil ditambahkan.';
    }
}

// ===================== SAVE KUNJUNGAN =====================
if(isset($_POST['save_kunjungan'])) {
    $d = $_POST;
    if(!empty($d['kid']) && $d['kid'] > 0) {
        $s = $pdo->prepare('UPDATE tb_kunjungan_hamil SET tgl_periksa=?,usia_kehamilan_minggu=?,bb_kg=?,tb_cm=?,tekanan_darah=?,tfu_cm=?,djj=?,presentasi_janin=?,edema=?,hb=?,tablet_fe=?,imunisasi_tt=?,vitamin=?,catatan_kunjungan=? WHERE id=?');
        $s->execute([$d['tgl_periksa'],$d['usia_kehamilan'],$d['bb'],$d['tb'],$d['tekanan_darah'],$d['tfu'],$d['djj'],$d['presentasi'],$d['edema'],$d['hb'],$d['tablet_fe'],$d['imunisasi_tt'],$d['vitamin'],$d['catatan_kunjungan'],$d['kid']]);
        $msg = 'success|Data kunjungan berhasil diperbarui.';
    } else {
        $s = $pdo->prepare('INSERT INTO tb_kunjungan_hamil (id_ibu,tgl_periksa,usia_kehamilan_minggu,bb_kg,tb_cm,tekanan_darah,tfu_cm,djj,presentasi_janin,edema,hb,tablet_fe,imunisasi_tt,vitamin,catatan_kunjungan) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $s->execute([$d['id_ibu'],$d['tgl_periksa'],$d['usia_kehamilan'],$d['bb'],$d['tb'],$d['tekanan_darah'],$d['tfu'],$d['djj'],$d['presentasi'],$d['edema'],$d['hb'],$d['tablet_fe'],$d['imunisasi_tt'],$d['vitamin'],$d['catatan_kunjungan']]);
        $msg = 'success|Data kunjungan berhasil disimpan.';
    }
}

// ===================== DELETE via POST (fix: cancel tidak hapus) =====================
if(isset($_POST['del_ibu']) && is_numeric($_POST['del_ibu'])) {
    $pdo->prepare('DELETE FROM tb_ibu_hamil WHERE id=?')->execute([$_POST['del_ibu']]);
    $msg = 'warning|Data ibu hamil berhasil dihapus.';
}
if(isset($_POST['del_kunjungan']) && is_numeric($_POST['del_kunjungan'])) {
    $id_ibu_back = $_POST['id_ibu_back'] ?? null;
    $pdo->prepare('DELETE FROM tb_kunjungan_hamil WHERE id=?')->execute([$_POST['del_kunjungan']]);
    $msg = 'warning|Data kunjungan berhasil dihapus.';
    if($id_ibu_back) { header("Location: ibu_hamil.php?view=$id_ibu_back&msg=del_kunjungan"); exit; }
}

// ===================== FETCH =====================
$ibu_list = $pdo->query('SELECT * FROM tb_ibu_hamil ORDER BY aktif DESC, tgl_daftar DESC')->fetchAll();
$detail_ibu = null; $kunjungan_list = []; $edit_kunjungan = null; $edit_ibu = null;

if(isset($_GET['view']) && is_numeric($_GET['view'])) {
    $sq = $pdo->prepare('SELECT * FROM tb_ibu_hamil WHERE id=?'); $sq->execute([$_GET['view']]); $detail_ibu = $sq->fetch();
    $sk = $pdo->prepare('SELECT * FROM tb_kunjungan_hamil WHERE id_ibu=? ORDER BY tgl_periksa DESC'); $sk->execute([$_GET['view']]); $kunjungan_list = $sk->fetchAll();
}
if(isset($_GET['edit_ibu']) && is_numeric($_GET['edit_ibu'])) {
    $sq = $pdo->prepare('SELECT * FROM tb_ibu_hamil WHERE id=?'); $sq->execute([$_GET['edit_ibu']]); $edit_ibu = $sq->fetch();
}
if(isset($_GET['edit_kunjungan']) && is_numeric($_GET['edit_kunjungan'])) {
    $sq = $pdo->prepare('SELECT * FROM tb_kunjungan_hamil WHERE id=?'); $sq->execute([$_GET['edit_kunjungan']]); $edit_kunjungan = $sq->fetch();
    if($edit_kunjungan) {
        $si = $pdo->prepare('SELECT * FROM tb_ibu_hamil WHERE id=?'); $si->execute([$edit_kunjungan['id_ibu']]); $detail_ibu = $si->fetch();
        $sk = $pdo->prepare('SELECT * FROM tb_kunjungan_hamil WHERE id_ibu=? ORDER BY tgl_periksa DESC'); $sk->execute([$edit_kunjungan['id_ibu']]); $kunjungan_list = $sk->fetchAll();
    }
}

// msg dari redirect
if(isset($_GET['msg'])) {
    if($_GET['msg']==='del_kunjungan') $msg='warning|Data kunjungan berhasil dihapus.';
}

include 'header.php';
$msg_type=''; $msg_text='';
if($msg) { [$msg_type,$msg_text] = explode('|',$msg,2); }
?>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h3 class="mb-0"><i class="fa fa-female me-2 text-danger"></i>Data Ibu Hamil</h3>
    <div class="d-flex gap-2 flex-wrap">
        <?php if($detail_ibu || $edit_ibu): ?>
        <a href="ibu_hamil.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        <?php endif; ?>
        <button class="btn btn-danger btn-sm" onclick="showModal('modalTambahIbu')">
            <i class="fa fa-plus me-1"></i>Tambah Ibu Hamil
        </button>
    </div>
</div>

<?php if($msg_text): ?>
<div class="alert alert-<?= $msg_type==='success'?'success':'warning' ?> d-flex align-items-center gap-2">
    <i class="fa fa-<?= $msg_type==='success'?'check-circle':'exclamation-triangle' ?>"></i>
    <?= htmlspecialchars($msg_text) ?>
</div>
<?php endif; ?>

<?php if(!$detail_ibu && !$edit_ibu): ?>
<!-- ===== LIST ===== -->
<div class="row g-3 mb-3">
    <?php
    $total  = count($ibu_list);
    $aktif  = count(array_filter($ibu_list,fn($i)=>$i['aktif']==1));
    $risiko = count(array_filter($ibu_list,fn($i)=>$i['status_risiko']==='Risiko Tinggi'));
    $lahir  = count(array_filter($ibu_list,fn($i)=>$i['aktif']==0));
    $cards  = [
        ['val'=>$total, 'label'=>'Total Terdaftar','icon'=>'fa-female','color'=>'danger'],
        ['val'=>$aktif, 'label'=>'Aktif Hamil',    'icon'=>'fa-heart',  'color'=>'success'],
        ['val'=>$risiko,'label'=>'Risiko Tinggi',  'icon'=>'fa-exclamation-triangle','color'=>'warning'],
        ['val'=>$lahir, 'label'=>'Sudah Melahirkan','icon'=>'fa-baby-carriage','color'=>'purple'],
    ];
    foreach($cards as $c): $col = $c['color']==='purple'?'style="color:#6f42c1"':''; ?>
    <div class="col-6 col-md-3">
        <div class="stat-card shadow-sm">
            <div class="stat-icon <?= $c['color']!=='purple'?'text-'.$c['color']:'' ?>" <?= $col ?>><i class="fa <?= $c['icon'] ?>"></i></div>
            <div class="stat-number <?= $c['color']!=='purple'?'text-'.$c['color']:'' ?>" <?= $col ?>><?= $c['val'] ?></div>
            <div class="stat-label"><?= $c['label'] ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="fa fa-list me-2"></i>Daftar Ibu Hamil</span>
        <input type="text" id="searchIbu" class="form-control form-control-sm" style="max-width:220px" placeholder="🔍 Cari nama / NIK...">
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" id="tblIbu">
                <thead class="posyandu-thead-primary">
                    <tr><th>No</th><th>NIK</th><th>Nama</th><th>Usia</th><th>HPHT</th><th>HPL</th><th>Gravida</th><th>Gol. Darah</th><th>Status Risiko</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if(!$ibu_list): ?><tr><td colspan="11" class="text-center py-4" style="color:var(--text-muted)">Belum ada data</td></tr><?php endif; ?>
                <?php $no=1; foreach($ibu_list as $d): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($d['nik']) ?></td>
                    <td><strong><?= htmlspecialchars($d['nama']) ?></strong><br><small style="color:var(--text-muted)">Suami: <?= htmlspecialchars($d['nama_suami']??'-') ?></small></td>
                    <td><?= $d['umur'] ?> thn</td>
                    <td><?= $d['hpht']?date('d/m/Y',strtotime($d['hpht'])):'-' ?></td>
                    <td><?= $d['hpl']?date('d/m/Y',strtotime($d['hpl'])):'-' ?></td>
                    <td><span class="badge bg-info text-dark">G<?= $d['gravida'] ?>P<?= $d['paritas'] ?>A<?= $d['abortus'] ?></span></td>
                    <td><?= $d['golongan_darah']??'-' ?></td>
                    <td><?php $rc=['Normal'=>'success','Risiko Rendah'=>'warning','Risiko Tinggi'=>'danger']; $r=$d['status_risiko']??'Normal'; ?>
                        <span class="badge bg-<?= $rc[$r]??'secondary' ?> <?= $r==='Risiko Rendah'?'text-dark':'' ?>"><?= $r ?></span></td>
                    <td><span class="badge <?= $d['aktif']?'bg-success':'bg-secondary' ?>"><?= $d['aktif']?'Aktif':'Melahirkan' ?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="ibu_hamil.php?view=<?= $d['id'] ?>" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-eye"></i></a>
                            <a href="ibu_hamil.php?edit_ibu=<?= $d['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                            <!-- DELETE via POST form agar cancel tidak hapus -->
                            <form method="post" action="ibu_hamil.php" class="d-inline" onsubmit="return konfirmasiHapus(this,'Hapus data ibu hamil ini beserta seluruh riwayat kunjungan?')">
                                <input type="hidden" name="del_ibu" value="<?= $d['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php elseif($edit_ibu): ?>
<!-- ===== FORM EDIT IBU ===== -->
<div class="card shadow-sm" style="border-left:4px solid #dc3545">
    <div class="card-header"><i class="fa fa-edit me-2"></i>Edit Data — <strong><?= htmlspecialchars($edit_ibu['nama']) ?></strong></div>
    <div class="card-body">
        <form method="post" action="ibu_hamil.php">
            <input type="hidden" name="id" value="<?= $edit_ibu['id'] ?>">
            <?php $d=$edit_ibu; include '_form_ibu_hamil_fields.php'; ?>
            <div class="text-end mt-3 d-flex gap-2 justify-content-end flex-wrap">
                <a href="ibu_hamil.php" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                <button type="submit" name="save_ibu" class="btn btn-danger"><i class="fa fa-save me-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ===== DETAIL KUNJUNGAN ===== -->
<div class="card shadow-sm mb-3" style="border-left:4px solid #dc3545">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3"><small style="color:var(--text-muted)">Nama</small><div class="fw-bold"><?= htmlspecialchars($detail_ibu['nama']) ?></div></div>
            <div class="col-md-2"><small style="color:var(--text-muted)">NIK</small><div><?= htmlspecialchars($detail_ibu['nik']) ?></div></div>
            <div class="col-md-2"><small style="color:var(--text-muted)">Usia / Gol. Darah</small><div><?= $detail_ibu['umur'] ?> thn / <?= $detail_ibu['golongan_darah']??'-' ?></div></div>
            <div class="col-md-3"><small style="color:var(--text-muted)">HPHT → HPL</small><div><?= $detail_ibu['hpht']?date('d/m/Y',strtotime($detail_ibu['hpht'])):'-' ?> → <?= $detail_ibu['hpl']?date('d/m/Y',strtotime($detail_ibu['hpl'])):'-' ?></div></div>
            <div class="col-md-2"><small style="color:var(--text-muted)">Status Risiko</small><div>
                <?php $r=$detail_ibu['status_risiko']??'Normal'; $rc=['Normal'=>'success','Risiko Rendah'=>'warning','Risiko Tinggi'=>'danger']; ?>
                <span class="badge bg-<?= $rc[$r] ?> <?= $r==='Risiko Rendah'?'text-dark':'' ?>"><?= $r ?></span>
            </div></div>
        </div>
        <?php if($detail_ibu['faktor_risiko']): ?>
        <div class="mt-2"><small style="color:var(--text-muted)">Faktor Risiko:</small> <span class="badge bg-danger"><?= htmlspecialchars($detail_ibu['faktor_risiko']) ?></span></div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h5 class="mb-0"><i class="fa fa-calendar-check me-2"></i>Riwayat Kunjungan (<?= count($kunjungan_list) ?>x)</h5>
    <button class="btn btn-danger btn-sm" onclick="showModal('modalKunjungan')"><i class="fa fa-plus me-1"></i>Tambah Kunjungan</button>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="posyandu-thead-primary">
                    <tr><th>No</th><th>Tgl Periksa</th><th>Usia Keh.</th><th>BB</th><th>TD</th><th>TFU</th><th>DJJ</th><th>Presentasi</th><th>Edema</th><th>Hb</th><th>Tablet Fe</th><th>Imun. TT</th><th>Vitamin</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if(!$kunjungan_list): ?><tr><td colspan="15" class="text-center py-4" style="color:var(--text-muted)">Belum ada riwayat kunjungan</td></tr><?php endif; ?>
                <?php $no=1; foreach($kunjungan_list as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y',strtotime($k['tgl_periksa'])) ?></td>
                    <td><span class="badge bg-primary"><?= $k['usia_kehamilan_minggu'] ?> mgg</span></td>
                    <td><?= $k['bb_kg'] ?> kg</td>
                    <td><?php $td=$k['tekanan_darah']; $p=explode('/',$td); $tc='bg-success';
                        if(count($p)==2){$s=(int)$p[0];if($s>=140||(int)$p[1]>=90)$tc='bg-danger';elseif($s>=130)$tc='bg-warning text-dark';}
                    ?><span class="badge <?= $tc ?>"><?= htmlspecialchars($td) ?></span></td>
                    <td><?= $k['tfu_cm'] ?> cm</td>
                    <td><?= $k['djj'] ?> dpm</td>
                    <td><?= htmlspecialchars($k['presentasi_janin']??'-') ?></td>
                    <td><?php $ec=['Tidak'=>'success','Ringan'=>'warning','Sedang'=>'warning','Berat'=>'danger']; $e=$k['edema']??'Tidak'; ?>
                        <span class="badge bg-<?= $ec[$e]??'secondary' ?> <?= $e!=='Tidak'?'text-dark':'' ?>"><?= $e ?></span></td>
                    <td><span class="badge bg-<?= (float)$k['hb']>=11?'success':'danger' ?>"><?= $k['hb'] ?></span></td>
                    <td><?= $k['tablet_fe'] ?> tab</td>
                    <td><?= $k['imunisasi_tt']??'-' ?></td>
                    <td style="max-width:100px;white-space:normal;font-size:0.8rem"><?= htmlspecialchars($k['vitamin']??'-') ?></td>
                    <td style="max-width:120px;white-space:normal;font-size:0.8rem"><?= htmlspecialchars($k['catatan_kunjungan']??'-') ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="ibu_hamil.php?view=<?= $detail_ibu['id'] ?>&edit_kunjungan=<?= $k['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                            <form method="post" action="ibu_hamil.php" class="d-inline" onsubmit="return konfirmasiHapus(this,'Hapus kunjungan ini?')">
                                <input type="hidden" name="del_kunjungan" value="<?= $k['id'] ?>">
                                <input type="hidden" name="id_ibu_back" value="<?= $detail_ibu['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ===== MODAL TAMBAH IBU — Full page scroll fix ===== -->
<div id="modalTambahIbu" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <div class="modal-header-custom" style="background:linear-gradient(135deg,#dc3545,#a71d2a)">
            <h5 class="mb-0 text-white"><i class="fa fa-plus me-2"></i>Tambah Data Ibu Hamil</h5>
            <button onclick="hideModal('modalTambahIbu')" class="modal-close-btn">✕</button>
        </div>
        <div class="modal-body-custom">
            <form method="post" action="ibu_hamil.php">
                <input type="hidden" name="id" value="0">
                <?php $d=null; include '_form_ibu_hamil_fields.php'; ?>
                <div class="text-end mt-3 d-flex gap-2 justify-content-end flex-wrap">
                    <button type="button" class="btn btn-outline-secondary" onclick="hideModal('modalTambahIbu')"><i class="fa fa-times me-1"></i>Batal</button>
                    <button type="submit" name="save_ibu" class="btn btn-danger"><i class="fa fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL TAMBAH/EDIT KUNJUNGAN ===== -->
<?php if($detail_ibu): ?>
<div id="modalKunjungan" class="modal-overlay" style="display:<?= $edit_kunjungan?'flex':'none' ?>">
    <div class="modal-box">
        <div class="modal-header-custom" style="background:linear-gradient(135deg,#0d6efd,#0056d6)">
            <h5 class="mb-0 text-white"><i class="fa fa-stethoscope me-2"></i><?= $edit_kunjungan?'Edit':'Tambah' ?> Kunjungan — <?= htmlspecialchars($detail_ibu['nama']) ?></h5>
            <button onclick="hideModal('modalKunjungan')" class="modal-close-btn">✕</button>
        </div>
        <div class="modal-body-custom">
            <form method="post" action="ibu_hamil.php?view=<?= $detail_ibu['id'] ?>">
                <input type="hidden" name="id_ibu" value="<?= $detail_ibu['id'] ?>">
                <input type="hidden" name="kid" value="<?= $edit_kunjungan?$edit_kunjungan['id']:0 ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tgl_periksa" class="form-control" value="<?= $edit_kunjungan?$edit_kunjungan['tgl_periksa']:date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Usia Kehamilan (minggu)</label>
                        <input type="number" name="usia_kehamilan" class="form-control" min="1" max="42" value="<?= $edit_kunjungan?$edit_kunjungan['usia_kehamilan_minggu']:'' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="bb" class="form-control" value="<?= $edit_kunjungan?$edit_kunjungan['bb_kg']:'' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" name="tb" class="form-control" value="<?= $edit_kunjungan?$edit_kunjungan['tb_cm']:'' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tekanan Darah <small>(mis: 120/80)</small></label>
                        <input name="tekanan_darah" class="form-control" placeholder="120/80" value="<?= $edit_kunjungan?htmlspecialchars($edit_kunjungan['tekanan_darah']):'' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">TFU / Tinggi Fundus (cm)</label>
                        <input type="number" step="0.1" name="tfu" class="form-control" value="<?= $edit_kunjungan?$edit_kunjungan['tfu_cm']:'' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">DJJ / Detak Jantung Janin (dpm)</label>
                        <input type="number" name="djj" class="form-control" min="80" max="200" value="<?= $edit_kunjungan?$edit_kunjungan['djj']:'' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Presentasi Janin</label>
                        <select name="presentasi" class="form-select">
                            <?php foreach(['Kepala','Sungsang','Lintang','Miring','Belum Dapat Dinilai'] as $p): ?>
                            <option value="<?= $p ?>" <?= ($edit_kunjungan&&$edit_kunjungan['presentasi_janin']==$p)?'selected':'' ?>><?= $p ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Edema / Bengkak</label>
                        <select name="edema" class="form-select">
                            <?php foreach(['Tidak','Ringan','Sedang','Berat'] as $e): ?>
                            <option value="<?= $e ?>" <?= ($edit_kunjungan&&$edit_kunjungan['edema']==$e)?'selected':'' ?>><?= $e ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hemoglobin / Hb (g/dL)</label>
                        <input type="number" step="0.1" name="hb" class="form-control" value="<?= $edit_kunjungan?$edit_kunjungan['hb']:'' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tablet Fe (jumlah)</label>
                        <input type="number" name="tablet_fe" class="form-control" min="0" value="<?= $edit_kunjungan?$edit_kunjungan['tablet_fe']:30 ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Imunisasi TT</label>
                        <select name="imunisasi_tt" class="form-select">
                            <?php foreach(['-','TT1','TT2','TT3','TT4','TT5'] as $tt): ?>
                            <option value="<?= $tt ?>" <?= ($edit_kunjungan&&$edit_kunjungan['imunisasi_tt']==$tt)?'selected':'' ?>><?= $tt ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vitamin / Suplemen</label>
                        <input name="vitamin" class="form-control" placeholder="Asam folat, Vitamin C, ..." value="<?= $edit_kunjungan?htmlspecialchars($edit_kunjungan['vitamin']??''):'' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan Kunjungan</label>
                        <textarea name="catatan_kunjungan" class="form-control" rows="2"><?= $edit_kunjungan?htmlspecialchars($edit_kunjungan['catatan_kunjungan']??''):'' ?></textarea>
                    </div>
                    <div class="col-12 text-end d-flex gap-2 justify-content-end flex-wrap">
                        <button type="button" class="btn btn-outline-secondary" onclick="hideModal('modalKunjungan')"><i class="fa fa-times me-1"></i>Batal</button>
                        <button type="submit" name="save_kunjungan" class="btn btn-primary"><i class="fa fa-save me-1"></i>Simpan Kunjungan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Konfirmasi hapus yang benar — cancel = form tidak submit
function konfirmasiHapus(form, pesan) {
    if(window.confirm(pesan)) { return true; }
    return false;
}
function showModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hideModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e){ if(e.target===this) hideModal(this.id); });
});
const si = document.getElementById('searchIbu');
if(si) si.addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tblIbu tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
// Auto-hitung HPL dari HPHT
document.querySelectorAll('[name=hpht]').forEach(el => {
    el.addEventListener('change', function(){
        if(!this.value) return;
        const d = new Date(this.value);
        d.setDate(d.getDate()+280);
        const hpl = d.toISOString().split('T')[0];
        // Cari hpl_display di form yang sama
        const form = this.closest('form') || document;
        const hplEl = form.querySelector('#hpl_display') || document.getElementById('hpl_display');
        if(hplEl) hplEl.value = hpl;
    });
});
</script>

<?php include 'footer.php'; ?>
