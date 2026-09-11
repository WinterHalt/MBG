<style>
.select2-container .select2-selection { height: 38px; }
.select2-container--default .select2-selection--single .select2-selection__rendered { margin-top: 3px; }
.select2-container--default .select2-selection--single .select2-selection__arrow { display: none; }

.panel-edit-heading {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
}

.btn-edit-trigger,
.btn-batal-edit,
.btn-kirim-edit {
  font-size: 13px;
  border-radius: 10px;
  cursor: pointer;
  transition: background 0.2s, opacity 0.2s;
}

.btn-edit-trigger {
  width: 40px;
  height: 40px;
  border: 1px solid #E8C4B8;
  background: #FFFFFF;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-edit-trigger:hover {
  background: #F5EDE9;
}

.btn-edit-trigger i {
  color: #B5614A;
  font-size: 16px;
}

.editable-action-group {
  display: none;
  gap: 10px;
}

.btn-batal-edit {
  color: #9C7B70;
  background: transparent;
  border: 1px solid #E8C4B8;
  padding: 9px 20px;
}

.btn-batal-edit:hover {
  background: #F5EDE9;
  color: #1C1410;
}

.btn-kirim-edit {
  color: white;
  background: #B5614A;
  border: none;
  padding: 9px 20px;
}

.btn-kirim-edit:hover {
  opacity: 0.88;
}

.editable-field[readonly],
.editable-field:disabled,
select.editable-field:disabled + .select2-container .select2-selection--single {
  background: #EDEDED;
  color: #9C7B70;
  cursor: not-allowed;
}

.btn-door-trigger {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: 1px solid #E8C4B8;
  background: #FFFFFF;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: background 0.2s;
}

.btn-door-trigger:hover {
  background: #F5EDE9;
}

.btn-door-trigger i {
  color: #B5614A;
  font-size: 16px;
}

.panel-edit-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}
</style>

<section class="panel">
  <div class="panel-edit-heading">
    <a href="<?= base_url('supplier') ?>" class="btn-door-trigger">
      <i class="fa fa-arrow-left"></i>
    </a>
    <div class="panel-edit-actions">
      <button type="button" class="btn-edit-trigger" id="btn_edit_supplier">
        <i class="fa fa-pen"></i>
      </button>
      <div class="editable-action-group" id="footer_edit_supplier">
        <button type="button" class="btn-batal-edit" id="btn_batal_supplier"><?php echo translate('cancel'); ?></button>
        <button type="submit" form="form_supplier" class="btn-kirim-edit"><?php echo translate('save'); ?></button>
      </div>
    </div>
  </div>
  <div class="tabs-custom">
    <div class="tab-content">
      <?php echo form_open('supplier/publish', array('class' => 'form-horizontal form-bordered validate', 'id' => 'form_supplier', 'name' => 'form_supplier')); ?>
          <div class="form-group <?php if (form_error('id')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Kode Supplier</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($result['id']); ?>" readonly>
							<span class="error"><?php echo form_error('id'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Nama <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control editable-field" id="name" name="name" value="<?php echo htmlspecialchars($result['name']); ?>" maxlength="250" readonly required />
							<span class="error"><?php echo form_error('name'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('position')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Posisi <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control editable-field" id="position" name="position" value="<?php echo htmlspecialchars($result['position']); ?>" maxlength="250" readonly required />
							<span class="error"><?php echo form_error('position'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Informasi Perusahaan</label>
					</div>
					<div class="form-group <?php if (form_error('company_name')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Nama <span class="required">*</span></label>
						<div class="col-md-2">
							<select class="form-control editable-field" id="jenis_usaha_id" name="jenis_usaha_id" disabled>
								<option value="<?php echo htmlspecialchars($result['jenis_usaha_id']); ?>" selected><?php echo htmlspecialchars($result['jenis_usaha']); ?></option>
							</select>
							<span class="error"><?php echo form_error('jenis_usaha_id'); ?></span>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control editable-field" id="company_name" name="company_name" value="<?php echo htmlspecialchars($result['company_name']); ?>" maxlength="250" readonly required />
							<span class="error"><?php echo form_error('company_name'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('address')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Alamat <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control editable-field" id="address" name="address" value="<?php echo htmlspecialchars($result['address']); ?>" maxlength="250" readonly required />
							<span class="error"><?php echo form_error('address'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('mobileno')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">No Telepon & Email <span class="required">*</span></label>
						<div class="col-md-2">
							<input type="number" class="form-control editable-field" id="mobileno" name="mobileno" value="<?php echo htmlspecialchars($result['mobileno']); ?>" maxlength="25" readonly required />
							<span class="error"><?php echo form_error('mobileno'); ?></span>
						</div>
						<div class="col-md-4">
							<input type="email" class="form-control editable-field" id="email" name="email" value="<?php echo htmlspecialchars($result['email']); ?>" maxlength="100" readonly required />
							<span class="error"><?php echo form_error('email'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('bank_id')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Bank <span class="required">*</span></label>
						<div class="col-12 col-md-2 mb-2 mb-md-0">
							<select class="form-control editable-field" id="bank_id" name="bank_id" disabled>
								<option value="<?php echo htmlspecialchars($result['bank_id']); ?>" selected><?php echo htmlspecialchars($result['bank']); ?></option>
							</select>
							<span class="error"><?php echo form_error('bank_id'); ?></span>
						</div>
						<div class="col-12 col-md-4 mb-2 mb-md-0">
							<input type="text" class="form-control editable-field" id="bank_acc" name="bank_acc" value="<?php echo htmlspecialchars($result['bank_acc']); ?>" maxlength="25" readonly required />
							<span class="error"><?php echo form_error('bank_acc'); ?></span>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
</section>

<script>
  function initEditablePanel(config) {
    var panel = $(config.panel);
    var trigger = $(config.trigger);
    var cancelButton = $(config.cancelButton);
    var footer = $(config.footer);
    var fields = panel.find(config.fieldSelector || '.editable-field');

    fields.each(function () {
      var el = $(this);
      if (el.is('select')) {
        el.data('original-html', el.html());
      } else {
        el.data('original-value', el.val());
      }
    });

    function setEditing(state) {
      fields.each(function () {
        var el = $(this);
        if (el.is('select')) {
          el.prop('disabled', !state);
        } else {
          if (state) {
            el.removeAttr('readonly');
          } else {
            el.attr('readonly', true);
          }
        }
      });
      if (state) {
        footer.css('display', 'flex');
        trigger.hide();
      } else {
        footer.hide();
        trigger.show();
      }
    }

    trigger.on('click', function () {
      setEditing(true);
    });

    cancelButton.on('click', function () {
      fields.each(function () {
        var el = $(this);
        if (el.is('select')) {
          el.html(el.data('original-html'));
        } else {
          el.val(el.data('original-value'));
        }
      });
      setEditing(false);
    });

    setEditing(false);

    return {
      setEditing: setEditing
    };
  }

  $(document).ready(function () {
    initSelect2("#jenis_usaha_id", "<?= base_url('refferal/get_jenis_usaha') ?>", "Pilih Jenis Usaha");
    initSelect2("#bank_id", "<?= base_url('refferal/get_bank') ?>", "Pilih Bank");

    initEditablePanel({
      panel: '#form_supplier',
      trigger: '#btn_edit_supplier',
      cancelButton: '#btn_batal_supplier',
      footer: '#footer_edit_supplier'
    });
  });
</script>