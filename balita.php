<?php
$title = 'Data Balita';
$active = 'balita';
require 'config.php';
require 'auth.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'save') {
    $nik = $_POST['nik'];
    $jk = $_POST['jenis_kelamin'];
    $nama = $_POST['nama'];
    $nama_ibu = $_POST['nama_ibu'];
    $umur = (int)$_POST['umur'];
    $bb = (float)$_POST['bb'];
    $tb = (float)$_POST['tb'];
    $status = $_POST['status'];
    $tgl = $_POST['tgl_periksa'];

    if ((int)$_POST['id'] == 0) {
        $s = $pdo->prepare('INSERT INTO tb_balita(nik, jenis_kelamin, nama, nama_ibu, umur_bulan, bb_kg, tb_cm, status_gizi, tgl_periksa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $s->execute([$nik, $jk, $nama, $nama_ibu, $umur, $bb, $tb, $status, $tgl]);
    } else {
        $s = $pdo->prepare('UPDATE tb_balita SET nik=?, jenis_kelamin=?, nama=?, nama_ibu=?, umur_bulan=?, bb_kg=?, tb_cm=?, status_gizi=?, tgl_periksa=? WHERE id=?');
        $s->execute([$nik, $jk, $nama, $nama_ibu, $umur, $bb, $tb, $status, $tgl, (int)$_POST['id']]);
    }
    header('Location: balita.php?msg=save_ok');
    exit;
}

if ($action === 'delete' && $id) {
    $pdo->prepare('DELETE FROM tb_balita WHERE id=?')->execute([$id]);
    header('Location: balita.php?msg=del_ok');
    exit;
}

include 'header.php';

if ($action === 'add' || ($action === 'edit' && $id)) {
    if ($action === 'edit') {
        $d = $pdo->prepare('SELECT * FROM tb_balita WHERE id=?');
        $d->execute([$id]);
        $d = $d->fetch();
    } else {
        $d = [
            'id' => 0,
            'nik' => '',
            'jenis_kelamin' => '',
            'nama' => '',
            'nama_ibu' => '',
            'umur_bulan' => '',
            'bb_kg' => '',
            'tb_cm' => '',
            'status_gizi' => 'Normal',
            'tgl_periksa' => date('Y-m-d')
        ];
    }
?>
<div class='card shadow-sm'>
    <div class='card-header d-flex justify-content-between align-items-center'>
        <h5 class='mb-0'><i class='fa fa-baby me-2'></i><?= $action === 'add' ? 'Tambah' : 'Edit' ?> Data Balita</h5>
        <a href='balita.php' class='btn btn-outline-secondary btn-sm'><i class='fa fa-arrow-left me-1'></i>Kembali</a>
    </div>
    <div class='card-body'>
        <form method='post' action='balita.php?action=save'>
            <input type='hidden' name='id' value='<?= (int)$d['id'] ?>'>
            <div class='row g-3'>
                <div class='col-md-6'>
                    <label class='form-label'>NIK</label>
                    <input name='nik' class='form-control' value='<?= htmlspecialchars($d['nik']) ?>' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Jenis Kelamin</label>
                    <select name='jenis_kelamin' class='form-select' required>
                        <option value='L' <?= ($d['jenis_kelamin']??'')=='L'?'selected':'' ?>>Laki-laki</option>
                        <option value='P' <?= ($d['jenis_kelamin']??'')=='P'?'selected':'' ?>>Perempuan</option>
                    </select>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Nama Balita</label>
                    <input name='nama' class='form-control' value='<?= htmlspecialchars($d['nama']) ?>' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Nama Ibu</label>
                    <input name='nama_ibu' class='form-control' value='<?= htmlspecialchars($d['nama_ibu']) ?>' required>
                </div>
                <div class='col-md-3'>
                    <label class='form-label'>Umur (bulan)</label>
                    <input type='number' name='umur' class='form-control' value='<?= htmlspecialchars($d['umur_bulan']) ?>' required min='0'>
                </div>
                <div class='col-md-3'>
                    <label class='form-label'>Tanggal Periksa</label>
                    <input type='date' name='tgl_periksa' class='form-control' value='<?= htmlspecialchars($d['tgl_periksa']) ?>' required>
                </div>
                <div class='col-md-3'>
                    <label class='form-label'>Berat Badan (kg)</label>
                    <input type='number' step='0.1' name='bb' class='form-control' value='<?= htmlspecialchars($d['bb_kg']) ?>' required min='0'>
                </div>
                <div class='col-md-3'>
                    <label class='form-label'>Tinggi Badan (cm)</label>
                    <input type='number' step='0.1' name='tb' class='form-control' value='<?= htmlspecialchars($d['tb_cm']) ?>' required min='0'>
                </div>
                <div class='col-md-3'>
                    <label class='form-label'>Status Gizi</label>
                    <select name='status' class='form-select'>
                        <?php foreach(['Normal','Kurang','Lebih'] as $s): ?>
                            <option value='<?= $s ?>' <?= $d['status_gizi']==$s?'selected':''; ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-12 text-end'>
                    <button class='btn btn-secondary' type='reset'><i class='fa fa-undo me-1'></i>Reset</button>
                    <button class='btn btn-primary'><i class='fa fa-save me-1'></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
} else {
    if (isset($_GET['cari']) && $_GET['cari'] != '') {
        $keyword = '%'.$_GET['cari'].'%';
        $s = $pdo->prepare("SELECT * FROM tb_balita WHERE nama LIKE ? OR nik LIKE ? ORDER BY tgl_periksa DESC");
        $s->execute([$keyword, $keyword]);
        $rows = $s->fetchAll();
    } else {
        $rows = $pdo->query('SELECT * FROM tb_balita ORDER BY tgl_periksa DESC')->fetchAll();
    }
?>
<div class='d-flex justify-content-between align-items-center mb-3'>
    <h3 class='mb-0'><i class='fa fa-baby me-2'></i>Data Balita</h3>
    <a href='balita.php?action=add' class='btn btn-primary'>
        <i class='fa fa-plus me-1'></i> Tambah Data
    </a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'save_ok'): ?>
    <div class='alert alert-success alert-dismissible fade show'>Data berhasil disimpan.<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'del_ok'): ?>
    <div class='alert alert-success alert-dismissible fade show'>Data berhasil dihapus.<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>
<?php endif; ?>

<div class='card shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
        <form method='get' class='mb-3'>
            <div class='input-group'>
                <input type='text' name='cari' class='form-control' placeholder='Cari Nama atau NIK...' value='<?= htmlspecialchars($_GET['cari'] ?? '') ?>'>
                <button class='btn btn-primary' type='submit'><i class='fa fa-search me-1'></i>Cari</button>
            </div>
        </form>
        <table class='table table-striped table-hover align-middle'>
            <thead class='posyandu-thead-primary' style='--bs-table-bg:transparent'>
                <tr>
                    <th>#</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Umur (bln)</th>
                    <th>Nama Ibu</th>
                    <th>Jenis Kelamin</th>
                    <th>BB (kg)</th>
                    <th>TB (cm)</th>
                    <th>Status Gizi</th>
                    <th>Tgl Periksa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($rows) == 0): ?>
                <tr><td colspan='11' class='text-center text-muted'>Belum ada data balita</td></tr>
                <?php endif; ?>
                <?php foreach($rows as $i=>$r): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($r['nik']) ?></td>
                    <td><?= htmlspecialchars($r['nama']) ?></td>
                    <td><?= (int)$r['umur_bulan'] ?></td>
                    <td><?= htmlspecialchars($r['nama_ibu'] ?? '') ?></td>
                    <td><?= $r['jenis_kelamin']=='L'?'Laki-laki':'Perempuan' ?></td>
                    <td><?= $r['bb_kg'] ?></td>
                    <td><?= $r['tb_cm'] ?></td>
                    <td>
                        <span class='badge bg-<?= $r['status_gizi']=='Normal'?'success':($r['status_gizi']=='Kurang'?'warning text-dark':'danger') ?>'>
                            <?= $r['status_gizi'] ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($r['tgl_periksa'])) ?></td>
                    <td>
                        <a href='balita.php?action=edit&id=<?= $r['id'] ?>' class='btn btn-sm btn-outline-primary' title='Edit'><i class='fa fa-edit'></i></a>
                        <a href='balita.php?action=delete&id=<?= $r['id'] ?>' class='btn btn-sm btn-outline-danger' title='Hapus' onclick="return confirm('Hapus data ini?')"><i class='fa fa-trash'></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div><!-- end table-responsive -->
    </div><!-- end card-body -->
</div><!-- end card -->
<?php
}
include 'footer.php';
?>
