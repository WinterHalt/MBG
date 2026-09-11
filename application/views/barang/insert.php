<!-- Custom Styling -->
<style>
  .select2-container .select2-selection { height: 38px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { margin-top: 3px; }
  .select2-container--default .select2-selection--single .select2-selection__arrow { display: none; }
</style>
<!-- Input Panel -->
<section class="panel">
  <div class="tabs-custom">
    <!-- Tab Content -->
    <div class="tab-content">
			<!-- Insert | Update | Detail on Supplier -->
			<?php echo form_open('barang/publish', array('class' => 'form-horizontal form-bordered validate', 'id' => 'form_supplier', 'name' => 'form_supplier')); ?>
          <!-- Kode Supplier -->
           
          <div class="form-group <?php if (form_error('id')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Kode Barang</label>
						<div class="col-md-6">
							<input type="text" class="form-control glass-input" id="id" name="id" readonly>
              <span class="error"><?php echo form_error('id'); ?></span>
						</div>
					</div>
					<!-- Nama Perorangan -->
					<div class="form-group <?php if (form_error('gases')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Barang</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="gases" name="gases" maxlength="250" required />
							<span class="error"><?php echo form_error('gases'); ?></span>
						</div>
					</div>
					<!-- Alamat Perusahaan -->
					<div class="form-group <?php if (form_error('barang')) echo 'has-error'; ?>">
            <label class="col-md-3 control-label">Total Milik</label>
						<div class="col-md-6">
              <input type="text" class="form-control glass-input" id="stock" name="stock" value="0" readonly>
              <span class="error"><?php echo form_error('stock'); ?></span>
						</div>
					</div>
          <!-- Unit Satuan -->
          <div class="form-group <?php if (form_error('barang')) echo 'has-error'; ?>">
            <label class="col-md-3 control-label">Unit</label>
						<div class="col-md-6">
              <select class="select2-barang sna" id="unit" name="unit" style="width:100%" data-placeholder="Pilih Unit">
                <option value="" selected disabled>Pilih Unit</option>
                <option value="Tabung">Tabung</option>
                <option value="Liter">Liter</option>
                <option value="Meter Kubik">Meter Kubik</option>
              </select>
              <span class="error"><?php echo form_error('unit'); ?></span>
						</div>
					</div>
					<!-- Footer -->
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block">
									<i class="fas fa-plus-circle"></i> <?php echo translate('save'); ?>
								</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
  </div>
</section>

<script>
  $(document).ready(function () {
    // Jenis Usaha Select 2
    initSelect2("#jenis_usaha_id", "<?= base_url('refferal/get_jenis_usaha') ?>", "Pilih Jenis Usaha");
    // Bank Select 2
    initSelect2("#bank_id", "<?= base_url('refferal/get_bank') ?>", "Pilih Bank");
  });
</script>