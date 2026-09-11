<!-- Final Version of Detail Pengeluaran Gas Medis -->
<!-- Custom Styling -->
<style>
  .select2-container .select2-selection { height: 38px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { margin-top: 3px; }
  .select2-container--default .select2-selection--single .select2-selection__arrow { display: none; }
</style>
<!-- Wrapper Panel Table Input -->
<section class="panel">
  <header class="panel-heading">
    <h4 class="panel-title"><i class="far fa-edit"></i>&nbsp;Input Pengeluaran Gas Medis</h4>
  </header>
  <!-- Panel Body -->
  <div class="panel-body">
    <!-- Melakukan Pemilihan Instalasi Minta Linen -->
    <div class="form-group">
      <div class="row">
        <!-- Tanggal -->
        <div class="col-sm-6">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" class="form-control" value="<?php echo $primary["tanggal"];?>" readonly>
        </div>
        <!-- Input Oleh -->
        <div class="col-sm-6">
          <label for="user" class="form-label">Input Oleh</label>
          <input type="text" class="form-control" value="<?php echo $primary["user"];?>" readonly>
        </div>
      </div>
    </div>
    <br>
    <!-- Table -->
    <table class="table" id="itemsTable">
      <thead>
        <tr>
          <th>Gas Medis</th>
          <th>Pagi</th>
          <th>Siang</th>
          <th>Malam</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($content as $index => $item): ?>
          <tr style="height:50px">
            <td><input type="text" value="<?php echo $item['gases'];?>" class="form-control" readonly></td>
            <td><input type="text" value="<?php echo number_format($item['pagi']);?>" class="form-control" readonly></td>
            <td><input type="text" value="<?php echo number_format($item['sore']);?>" class="form-control" readonly></td>
            <td><input type="text" value="<?php echo number_format($item['malam']);?>" class="form-control" readonly></td>
            <td><input type="text" value="<?php echo number_format($item['total']);?>" class="form-control" readonly></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
  </div>
  <!-- Panel Footer -->
  <div class="panel-footer">
    <div class="row">
      <div class="col-md-6">
        <button class="btn btn-default pull-left" onclick="history.back(); return false;">
          <i class="fas fa-arrow-left"></i> <?php echo translate('kembali'); ?>
        </button>
      </div>
    </div>
  </div>
</section>