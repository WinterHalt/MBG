<!-- Final Version of Detail Stock Opname -->
<section class="panel">
  <!-- Panel Body to Show Detail Value -->
  <div class="panel-body">
    <!-- Melakukan Pengisian Pengeluaran Medical Gases -->
    <div class="form-group">
      <div class="row">
        <!-- Tanggal -->
        <div class="col-sm-6">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" value="<?php echo $primary['tanggal'];?>" class="form-control" readonly>
        </div>
        <!-- Input Oleh -->
        <div class="col-sm-6">
          <label for="user" class="form-label">Input Oleh</label>
          <input type="text" class="form-control" value="<?php echo $primary['user'];?>" readonly>
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detail as $row): ?>
          <tr>
            <!-- Select Gas -->
            <td>
              <input type="text" class="form-control" value="<?php echo $row['gases'];?>" readonly>
            </td>
            <!-- Jumlah Sistem -->
            <td class="text-center">
              <input type="text" class="form-control" value="<?php echo $row['sistem'];?>" readonly>
            </td>
            <!-- Jumlah Fisik -->
            <td class="text-center">
              <input type="text" class="form-control" value="<?php echo $row['fisik'];?>" readonly>
            </td>
            <!-- Jumlah Selisih -->
            <td class="text-center">
              <input type="text" class="form-control" value="<?php echo $row['selisih'];?>" readonly>
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
    </div>
  </div>
</section>