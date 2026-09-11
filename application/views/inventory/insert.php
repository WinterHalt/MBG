<!-- Final Version of Input Formulir Stock Opname -->
<!-- Custom Styling -->
<style>
  .select2-container { width: 100% !important; }
  .select2-container .select2-selection { height: 38px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { margin-top: 3px; }
  .select2-container--default .select2-selection--single .select2-selection__arrow { display: none; }
</style>
<section class="panel">
  <!-- Panel Body of Formulir Publisher -->
  <?php echo form_open('inventory/publish', ['id' => 'form_keluar_gas']); ?>
    <!-- Panel to Input -->
    <div class="panel-body">
      <!-- Melakukan Pengisian Pengeluaran Medical Gases -->
      <div class="form-group">
        <div class="row">
          <!-- Tanggal -->
          <div class="col-sm-6">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
          </div>
          <!-- Input Oleh -->
          <div class="col-sm-6">
            <label for="user" class="form-label">Input Oleh</label>
            <input type="text" name="user" id="user" class="form-control" value="<?php echo username();?>" readonly>
          </div>
        </div>
      </div>
      <br>
      <!-- Table -->
      <table class="table">
        <thead>
          <tr>
            <th class="text-center">Medical Gas</th>
            <th class="text-center">Jumlah Sistem</th>
            <th class="text-center">Jumlah Fisik</th>
            <th class="text-center">Jumlah Selisih</th>
            <th class="text-center">Harga Satuan</th>
            <th class="text-center">Saldo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $row): ?>
            <tr>
              <!-- Select Gas -->
              <td>
                <select name="gases[]" class="selecta form-control" require>
                  <option value="<?php echo $row['id'];?>">
                    <?php echo $row['gases'];?>
                  </option>
                </select>
              </td>
              <!-- Jumlah Sistem -->
              <td class="text-center">
                <input type="number" name="sistem[]" id="sistem[]" class="systematic form-control" value="<?php echo $row['stock'];?>" readonly>
              </td>
              <!-- Jumlah Fisik -->
              <td class="text-center">
                <input type="number" name="fisik[]" id="fisik[]" class="physicality form-control" require>
              </td>
              <!-- Jumlah Selisih -->
              <td class="text-center">
                <input type="number" name="selisih[]" id="selisih[]" class="differential form-control" readonly>
              </td>
              <!-- Harga -->
              <td>
                <input type="number" name="price[]" id="price[]" value="<?php echo $row['harga'];?>" class="price form-control" readonly>
              </td>
              <!-- Saldo -->
              <td>
                <input type="number" name="saldo[]" id="saldo[]" class="saldo form-control" readonly>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Panel Footer to Close the File -->
    <div class="panel-footer">
    <div class="row">
      <!-- Kembali -->
      <div class="col-md-6">
        <button class="btn btn-default pull-left" onclick="history.back(); return false;">
          <i class="fas fa-arrow-left"></i> <?php echo translate('kembali'); ?>
        </button>
      </div>
      <!-- Final -->
      <div class="col-md-6">
        <button class="btn btn-dark pull-right" type="submit"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;<span>Simpan</span></button>
      </div>  
    </div>
  </div>
  <?php echo form_close(); ?>
</section>

<script>
  $(document).ready(function() {
    // === [1] Style on Select
    $('.selecta').select2({});
    // === [2] Diff Absolute
    $('.physicality').on('input', function() {
      var $row = $(this).closest('tr');
      var systematic = parseInt($row.find('.systematic').val()) || 0;
      var physicality = parseInt($(this).val()) || 0;
      var differential = Math.abs(systematic - physicality);
      var prices = parseInt($row.find('.price').val()) || 0;
      var saldo = physicality * prices;
      $row.find('.saldo').val(saldo);
      $row.find('.differential').val(differential);
    })
    // === [3] Tanggal
    const today = new Date();
    const formatDate = (date) => date.toISOString().split("T")[0];
    $('#tanggal').val(formatDate(today));
  })
</script>