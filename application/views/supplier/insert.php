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
			<?php echo form_open('supplier/publish', array('class' => 'form-horizontal form-bordered validate', 'id' => 'form_supplier', 'name' => 'form_supplier')); ?>
          <!-- Kode Supplier -->
          <div class="form-group <?php if (form_error('id')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Kode Supplier</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="id" name="id" readonly>
							<span class="error"><?php echo form_error('id'); ?></span>
						</div>
					</div>
					<!-- Nama Perorangan -->
					<div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Nama <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="name" name="name" maxlength="250" required />
							<span class="error"><?php echo form_error('name'); ?></span>
						</div>
					</div>
					<!-- Posisi Perorangan -->
					<div class="form-group <?php if (form_error('position')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Posisi <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="position" name="position" maxlength="250" required />
							<span class="error"><?php echo form_error('position'); ?></span>
						</div>
					</div>
					<!-- Perusahaan -->
					<div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Informasi Perusahaan</label>
					</div>
					<!-- Nama Perusahaan -->
					<div class="form-group <?php if (form_error('company_name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Nama <span class="required">*</span></label>
						<!-- Jenis Usaha -->
						<div class="col-md-2">
							<select class="form-control" id="jenis_usaha_id" name="jenis_usaha_id"></select>
							<span class="error"><?php echo form_error('jenis_usaha_id'); ?></span>
						</div>
						<!-- Nama Perusahaan -->
						<div class="col-md-4">
							<input type="text" class="form-control" id="company_name" name="company_name" maxlength="250" required />
							<span class="error"><?php echo form_error('company_name'); ?></span>
						</div>
					</div>
					<!-- Alamat Perusahaan -->
					<div class="form-group <?php if (form_error('address')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Alamat <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="address" name="address" maxlength="250" required />
							<span class="error"><?php echo form_error('address'); ?></span>
						</div>
					</div>
					<!-- Telepon & Electronic Mail -->
					<div class="form-group <?php if (form_error('mobileno')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">No Telepon & Email <span class="required">*</span></label>
						<!-- Telephone Perusahaan -->
						<div class="col-md-2">
							<input type="number" class="form-control" id="mobileno" name="mobileno" maxlength="25" required />
							<span class="error"><?php echo form_error('mobileno'); ?></span>
						</div>
						<!-- Email Perusahaan -->
						<div class="col-md-4">
							<input type="email" class="form-control" id="email" name="email" maxlength="100" required />
							<span class="error"><?php echo form_error('email'); ?></span>
						</div>
					</div>
					<!-- Bank -->
					<div class="form-group <?php if (form_error('bank_id')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Bank <span class="required">*</span></label>
						<div class="col-12 col-md-2 mb-2 mb-md-0">
							<select class="form-control" id="bank_id" name="bank_id"></select>
							<span class="error"><?php echo form_error('bank_id'); ?></span>
						</div>
						<!-- Rekening -->
						<div class="col-12 col-md-4 mb-2 mb-md-0">
							<input type="text" class="form-control" id="bank_acc" name="bank_acc" maxlength="25" required />
							<span class="error"><?php echo form_error('bank_acc'); ?></span>
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