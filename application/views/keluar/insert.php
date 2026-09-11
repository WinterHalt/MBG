<!-- Final Version of Pengeluaran Gas Medis Input Formulir -->
<style>
  .select2-container .select2-selection { height: 38px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { margin-top: 3px; }
  .select2-container--default .select2-selection--single .select2-selection__arrow { display: none; }
</style>

<section class="panel">
  <header class="panel-heading">
    <h4 class="panel-title"><i class="far fa-edit"></i>&nbsp;Input Pengeluaran Gas Medis</h4>
  </header>
  <?php echo form_open('keluar/publish', ['id' => 'form_keluar_gas']); ?>
  <div class="panel-body">
    <div class="form-group">
      <div class="row">
        <div class="col-sm-6">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label for="user" class="form-label">Input Oleh</label>
          <select name="user" id="user" class="form-control">
            <option value="<?php echo userids(); ?>">
              <?php echo username(); ?>
            </option>
          </select>
        </div>
      </div>
    </div>
    <br>
    <table class="table" id="itemsTable">
      <thead>
        <tr>
          <th class="text-center" colspan="2">Gas Medis</th>
          <th class="text-center">Pagi</th>
          <th class="text-center">Siang</th>
          <th class="text-center">Malam</th>
          <th class="text-center">Total</th>
          <th class="text-center">Hapus</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <br>
    <button type="button" id="addRow" class="btn btn-success" disabled><i class="fas fa-plus-circle"></i></button>
  </div>
  <div class="panel-footer">
    <div class="row">
      <div class="col-md-6">
        <button class="btn btn-default pull-left" onclick="history.back(); return false;">
          <i class="fas fa-arrow-left"></i> <?php echo translate('kembali'); ?>
        </button>
      </div>
      <div class="col-md-6">
        <button class="btn btn-dark pull-right" type="submit" id="btnSimpan">
          <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;<span>Simpan</span>
        </button>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</section>

<script>
$(document).ready(function () {
  // ?
  const $tbody = $('#itemsTable tbody');
  const $addRow = $('#addRow');
  $('#tanggal').val(new Date().toISOString().split("T")[0]);

  // === Init Gases Dropdown Source, then Enable Add Row
  globalgases("<?= base_url('barang/BarangOnly') ?>", "gases[]", "all", "totali");
  // ?
  $addRow.prop('disabled', false);

  // === Add Row
  $addRow.click(function () {
    const $row = $(`
      <tr style="height:50px">
        <td style="width:30%"><select name="gases[]" class="form-control gases-select" required></select></td>
        <td><input type="number" class="totali form-control" style="height:100%" readonly></td>
        <td><input type="number" name="pagi[]" class="form-control" style="height:100%" step="any" min="0"></td>
        <td><input type="number" name="sore[]" class="form-control" style="height:100%" step="any" min="0"></td>
        <td><input type="number" name="malam[]" class="form-control" style="height:100%" step="any" min="0"></td>
        <td><input type="number" name="total[]" class="form-control" style="height:100%" step="0.0001" readonly></td>
        <td><button type="button" class="btn btn-danger removeRow"><i class='fas fa-trash-alt'></i></button></td>
      </tr>
    `).appendTo($tbody);

    $row.find('.gases-select').select2({
      placeholder: "Pilih Gas",
      width: '100%',
      data: [{ id: '', text: 'Pilih Gas' }, ...gasOptions]
    }).next('.select2').find('.select2-selection').css({ 'margin-top': '1px', 'height': '33px' });

    updateGasesDropdowns("gases[]");
  });

  // === Remove Row
  $tbody.on('click', '.removeRow', function () {
    $(this).closest('tr').remove();
    updateGasesDropdowns("gases[]");
  });

  // === Compute Total, Guard Against Exceeding Stock
  $tbody.on('input', 'input[name="pagi[]"], input[name="siang[]"], input[name="malam[]"]', function () {
    const $row = $(this).closest('tr');
    const val = name => Math.max(0, parseFloat($row.find(`input[name="${name}[]"]`).val()) || 0);
    const limit = parseFloat($row.find('input.totali').val()) || 0;
    const total = val('pagi') + val('siang') + val('malam');
    const $total = $row.find('input[name="total[]"]');

    if (total <= limit) {
      $total.val(total.toFixed(4));
      $row.removeClass('table-danger');
    } else {
      $total.val('');
      $row.addClass('table-danger');
      Swal.fire({ title: 'Error !', html: "Melewati Jumlah Milik IPSRS !", type: 'error', confirmButtonText: 'OK' });
    }
  });

  // === Block Submit if Any Row Still Exceeds Stock
  $('#form_keluar_gas').on('submit', function (e) {
    if ($tbody.find('.table-danger').length > 0) {
      e.preventDefault();
      Swal.fire({ title: 'Error !', html: "Masih Ada Baris Yang Melewati Jumlah Stok !", type: 'error', confirmButtonText: 'OK' });
    }
  });
});
</script>