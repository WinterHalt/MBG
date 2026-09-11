<!-- Final Version of History Table of Stock Opname Activity -->
<!-- Custom Styling -->
<style>
  td { vertical-align: middle; }
</style>
<!-- Wrapper Panel on History Table of Stock Opname Activity -->
<section class="panel">
  <!-- Panel Title -->
  <header class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
    <h4 class="panel-title"><i class="fas fa-table"></i> Tabel Kegiatan Stock Opname</h4>
    <h4 class="panel-title">
      <a href="<?= base_url('inventory/insert') ?>" class="btn btn-default btn-tambah-pesanan">
        <i class="fa fa-plus"></i> Input Stock Opname
      </a>
    </h4>
  </header>
  <!-- Wrapper Panel Table on History of Stock Opname -->
  <div class="tabs-custom">
    <div class="tab-content">
      <div class="tab-pane box active">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">Tanggal</th>
                <th class="text-center">User</th>
                <th class="text-center">Detail</th>
              </tr>
            </thead>
            <!-- Table Content -->
            <tbody>
              <?php foreach ($results as $row): ?>
              <tr>
                <td class="text-center"><?php echo html_escape($row['tanggal']); ?></td>
                <td class="text-center"><?php echo html_escape($row['user']); ?></td>
                <!-- Detail Stock Opname -->
                <td class="text-center">
                  <a href="<?= base_url('inventory/detail/' . $row['id']); ?>" class="btn btn-circle icon btn-info">
                    <i class="fas fa-eye"></i>
                  </a>
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