<!-- Wrapper Panel Table & Input Supplier -->
<section class="panel">
  <header class="panel-heading d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 15px;">
    <h4 class="panel-title"></h4>
    <a href="<?php echo site_url('supplier/insert'); ?>" class="btn btn-tambah btn-sm" style="margin: 1;">
      Tambah Supplier
    </a>
  </header>
  <div class="tabs-custom">
    <!-- Tab Content -->
    <div class="tab-content">
			<div id="menu_list" name="menu_list" class="tab-pane <?php echo (!isset($validation_error) ? 'active' : ''); ?>">
				<div class="table-responsive mb-md">
					<div class="export_title">Tabel Supplier</div>
					<!-- Tabel Content -->
					<table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%" id="list_data" name="list_data">
						<thead>
							<tr>
								<th class="text-center">Sl.</th>
								<th class="text-center">Nama Pimpinan</th>
								<th class="text-center">Jabatan</th>
								<th class="text-center">Perusahaan</th>
								<th class="text-center">Telepon</th>
								<th class="text-center">Email</th>
								<th class="text-center"><?php echo translate('action'); ?></th>
							</tr>
						</thead>
						<tbody>
              <?php $count = 1; foreach ($results as $row): ?>
                <tr>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo $count++; ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['name']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['position']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['company_name']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['mobileno']); ?></td>
                  <td class="text-center" style="vertical-align: middle !important;"><?php echo html_escape($row['email']); ?></td>
                  <td class="text-center">
                    <!-- Edit Button -->
                    <a href="<?php echo site_url('supplier/detail/' . $row['id']); ?>" class="btn btn-circle icon btn-primary">
                      <i class="fas fa-pen-nib"></i>
                    </a>
                    <!-- Delete Button -->
                    <?php echo btn_delete('supplier/delete/' . $row['id']); ?>
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