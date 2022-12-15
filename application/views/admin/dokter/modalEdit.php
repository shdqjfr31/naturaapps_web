<div class="modal fade" id="modalEdit" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0dcaf0; color:white;">
        <h5 class="modal-title">Edit Dokter</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('admin/dokter/update', ['class' => 'formUpdate', 'method' => 'POST']) ?>
      <!-- <form action="<?= base_url('admin/dokter/simpan') ?>" method="POST" class="formSimpan"> -->
      <div class="pesan" style="display: none;"></div>
      <div class="modal-body">
        <div class="form-group row">
          <div class="mb-3">
            <label for="KODE" class="form-label">Kode</label>
            <input type="text" name="KODE" class="form-control" readonly="true" value="<?= $KODE ?>" id="KODE" maxlength="8">
          </div>
        </div>
        <div class="form-group row">
          <div class="mb-3">
            <label for="NAMA" class="form-label">Nama</label>
            <input type="text" name="NAMA" value="<?= $NAMA ?>" class="form-control" placeholder="Nama" id="NAMA">
          </div>
        </div>
        <div class="form-group row">
          <div class="mb-3">
            <!-- <?= var_dump($nm_poli); ?> -->
            <label for="SPESIALIS" class="form-label">Spesialis</label>
            <select name="SPESIALIS" id="" class="form-select">
              <option value="<?= $SPESIALIS ?>" selected><?= $SPESIALIS ?></option>
              <?php foreach ($nm_poli as $poli) { ?>
                <option value="<?= "POLIKLINIK " . $poli->NM_POLI ?>"><?= "POLIKLINIK " . $poli->NM_POLI ?></option>
              <?php  } ?>
            </select>
          </div>
        </div>
        <!-- <div class="form-group row">
          <div class=" mb-3">
            <label for="AKTIF" class="form-label">Aktif</label>
            <input type="text" name="AKTIF" class="form-control" value="<?= $AKTIF ?>" id="AKTIF">
          </div>
        </div> -->
        <div class="form-group row">
          <div class=" mb-3">
            <label for="AKTIF" class="form-label">Aktif</label>
            <!-- <input type="text" name="AKTIF" class="form-control" placeholder="Aktif" id="AKTIF"> -->
            <select name="AKTIF" id="AKTIF" class="form-select">
              <?php if ($AKTIF == 1) {
                echo "<option value=1 selected>Aktif</option>
                <option value=0>Nonaktif</option>";
              } else {
                echo
                "<option value=0 selected>Nonaktif</option>
                <option value=1>Aktif</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <!-- <div class="form-group row">
            <div class="mb-3">
              <label for="FOTO" class="form-label">Foto</label>
              <input type="file" name="FOTO" class="form-control" placeholder="Foto" id="FOTO">
            </div>
          </div> -->
      </div>
      <div class="modal-footer">
        <button type="submit" id="oke" class="btn btn-info"><i class="bi bi-save"></i> Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
      <!-- </form> -->
    </div>
  </div>
</div>
<!-- <script>
  $(document).ready(function() {
    $("form").submit(function() {
      alert("Submitted");
    });
  });
</script>
<button class="btn btn-primary">yeyeyeyey</button> -->
<!-- <script src="<?php echo config_item('datatables'); ?>jQuery-3.5.1/jquery-3.5.1.min.js"></script> -->
<script>
  $(document).ready(function() {
    $('.formUpdate').submit(function(e) {
      $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.error) {
            $('.pesan').html(response.error).show();
          }

          if (response.sukses) {
            swal.fire({
              icon: 'success',
              customClass: {
                confirmButton: 'btn btn-success mx-1',
              },
              buttonsStyling: false,
              title: 'Berhasil',
              text: response.sukses
            });
            $('#modalEdit').modal('hide');
            $('#myTable').DataTable().ajax.reload();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;

    });

  });
</script>