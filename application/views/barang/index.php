<!-- Wrapper Panel Table & Input Barang -->
<section class="panel">
  <header class="panel-heading d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 15px;">
    <h4 class="panel-title">
      <i class="fa fa-bars"></i>
      &nbsp;Tabel Barang
    </h4>
    <!-- Input Panel I : Data Baru -->
    <a href="<?php echo site_url('barang/insert'); ?>" class="btn btn-tambah btn-sm" style="margin: 1;">
      Tambah Supplier
    </a>
  </header>
  <div class="tabs-custom">
    <!-- Tab Content -->
    <div class="tab-content">
      <div id="menu_list" name="menu_list" class="tab-pane <?php echo (!isset($validation_error) ? 'active' : ''); ?>">
        <div class="table-responsive mb-md">
          <div class="export_title">Tabel Barang</div>
          <!-- Tabel Content -->
          <table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%" id="list_data" name="list_data">
            <thead>
              <tr>
                <th class="text-center">Sl.</th>
                <th class="text-center">Barang</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Satuan</th>
                <th class="text-center"><?php echo translate('action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1; foreach ($results as $row): ?>
                <tr>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo $count++; ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['gases']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['stock']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['unit']); ?></td>
                  <td class="text-center">
                    <!-- Edit Button -->
                    <a href="<?php echo site_url('barang/detail/' . $row['id']); ?>" class="btn btn-circle icon btn-primary" title="Edit Barang">
                      <i class="fas fa-pen-nib"></i>
                    </a>
                    <!-- Delete Button -->
                    <?php echo btn_delete('barang/delete/' . $row['id']); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
$('#modalBarang').on('show.bs.modal', function (e) {
  // Variable
  var trigger = $(e.relatedTarget);
  var mode = trigger.data('mode');
  var id = trigger.data('id');
  var modal = $(this);
  // Reset Form
  modal.find('#formBarang')[0].reset();
  modal.find('.select2-barang').val(null).trigger('change');
  // Reset State
  modal.find('#formBarang input, #formBarang textarea').prop('readonly', false);
  modal.find('#formBarang select').prop('disabled', false);
  modal.find('.btn-simpan').show();
  // Kode Barang & Total Milik selalu readonly
  modal.find('#id, #stock').prop('readonly', true);
  // Insert Data
  if (mode === 'insert') {
    modal.find('.modal-title').text('Tambah Barang');
    modal.find('#formBarang').attr('action', '<?= base_url("barang/publish") ?>');
  // Perubahan Data
  } else if (mode === 'edit') {
    modal.find('.modal-title').text('Edit Barang');
    modal.find('#formBarang').attr('action', '<?= base_url("barang/publish/") ?>' + id);
    fetchBarang(id, modal);
  }
});

// ==================== Helper: Fetch & Populate Form ====================
function fetchBarang(id, modal) {
  // Controller
  $.ajax({
    url: "<?= base_url('barang/detail/') ?>" + id,
    type: "GET",
    dataType: "json",
    success: function (res) {
      // Populate Input
      modal.find('#id').val(res.id);
      modal.find('#gases').val(res.gases);
      modal.find('#stock').val(res.stock);
      // Populate Select
      modal.find('#unit').val(res.unit).trigger('change');
    }
  });
}
</script>