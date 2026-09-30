<?php /* Inline edit page, $edit_ibu is set, assign to $d for the fields */ ?>
<form method="post" action="ibu_hamil.php">
    <input type="hidden" name="id" value="<?= $edit_ibu['id'] ?>">
    <?php $d = $edit_ibu; include '_form_ibu_hamil_fields.php'; ?>
    <div class="d-flex gap-2 justify-content-end mt-3">
        <a href="ibu_hamil.php" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
        <button type="submit" name="save_ibu" class="btn btn-danger"><i class="fa fa-save me-1"></i>Simpan Perubahan</button>
    </div>
</form>
