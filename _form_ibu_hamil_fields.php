<?php /* $d = data ibu (null untuk tambah baru, array untuk edit) */ ?>
<div class="row g-3">
    <div class="col-12"><h6 class="border-bottom pb-2" style="color:var(--accent)"><i class="fa fa-id-card me-1"></i>Data Identitas</h6></div>
    <div class="col-md-6">
        <label class="form-label">NIK</label>
        <input name="nik" class="form-control" value="<?= $d?htmlspecialchars($d['nik']):'' ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input name="nama" class="form-control" value="<?= $d?htmlspecialchars($d['nama']):'' ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" class="form-control" value="<?= $d?$d['tgl_lahir']:'' ?>">
    </div>
    <div class="col-md-2">
        <label class="form-label">Umur (thn)</label>
        <input type="number" name="umur" class="form-control" min="10" max="60" value="<?= $d?$d['umur']:'' ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Suami</label>
        <input name="nama_suami" class="form-control" value="<?= $d?htmlspecialchars($d['nama_suami']??''):'' ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Alamat</label>
        <input name="alamat" class="form-control" value="<?= $d?htmlspecialchars($d['alamat']??''):'' ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">No. HP</label>
        <input name="no_hp" class="form-control" value="<?= $d?htmlspecialchars($d['no_hp']??''):'' ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Golongan Darah</label>
        <select name="golongan_darah" class="form-select">
            <?php foreach([''=>'- Pilih -','A'=>'A','B'=>'B','AB'=>'AB','O'=>'O'] as $v=>$lb): ?>
            <option value="<?= $v ?>" <?= ($d&&($d['golongan_darah']??'')===$v)?'selected':'' ?>><?= $lb ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12 mt-1"><h6 class="border-bottom pb-2" style="color:#dc3545"><i class="fa fa-baby-carriage me-1"></i>Data Kehamilan</h6></div>
    <div class="col-6 col-md-2">
        <label class="form-label">Gravida (ke-)</label>
        <input type="number" name="gravida" class="form-control" min="1" value="<?= $d?$d['gravida']:1 ?>" required>
    </div>
    <div class="col-6 col-md-2">
        <label class="form-label">Paritas</label>
        <input type="number" name="paritas" class="form-control" min="0" value="<?= $d?$d['paritas']:0 ?>">
    </div>
    <div class="col-6 col-md-2">
        <label class="form-label">Abortus</label>
        <input type="number" name="abortus" class="form-control" min="0" value="<?= $d?$d['abortus']:0 ?>">
    </div>
    <div class="col-6 col-md-2">
        <label class="form-label">Anak Hidup</label>
        <input type="number" name="jumlah_anak_hidup" class="form-control" min="0" value="<?= $d?$d['jumlah_anak_hidup']:0 ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="aktif" class="form-select">
            <option value="1" <?= (!$d||$d['aktif'])?'selected':'' ?>>Aktif Hamil</option>
            <option value="0" <?= ($d&&!$d['aktif'])?'selected':'' ?>>Sudah Melahirkan</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">HPHT <small style="color:var(--text-muted)">(Hari Pertama Haid Terakhir)</small></label>
        <input type="date" name="hpht" class="form-control" value="<?= $d?$d['hpht']:'' ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">HPL <small style="color:var(--text-muted)">(otomatis HPHT+280 hari)</small></label>
        <input type="date" name="hpl" id="hpl_display" class="form-control" value="<?= $d?$d['hpl']:'' ?>" readonly style="background:rgba(13,110,253,0.06);">
    </div>

    <div class="col-12 mt-1"><h6 class="border-bottom pb-2" style="color:#ffc107"><i class="fa fa-exclamation-triangle me-1"></i>Status Risiko</h6></div>
    <div class="col-md-4">
        <label class="form-label">Status Risiko</label>
        <select name="status_risiko" class="form-select">
            <?php foreach(['Normal','Risiko Rendah','Risiko Tinggi'] as $sr): ?>
            <option value="<?= $sr ?>" <?= ($d&&$d['status_risiko']===$sr)?'selected':'' ?>><?= $sr ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-8">
        <label class="form-label">Faktor Risiko <small style="color:var(--text-muted)">(jika ada)</small></label>
        <input name="faktor_risiko" class="form-control" placeholder="Anemia, hipertensi, dll..." value="<?= $d?htmlspecialchars($d['faktor_risiko']??''):'' ?>">
    </div>
    <div class="col-12">
        <label class="form-label">Catatan Tambahan</label>
        <textarea name="catatan" class="form-control" rows="2"><?= $d?htmlspecialchars($d['catatan']??''):'' ?></textarea>
    </div>
</div>
