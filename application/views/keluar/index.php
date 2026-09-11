<!-- Final Version of Main Table Pengeluaran Gas Medis View -->
<!-- Custom Styling -->
<style>
  .select2-container .select2-selection--single { height: 34px !important; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { 
    line-height: 32px !important; 
    padding-left: 12px; 
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow { height: 32px !important; }
  #laporan-body td {
    vertical-align: middle;
    padding-top: 8px;
    padding-bottom: 8px;
  }
</style>
<!-- Wrapper Panel Input Filter on Table -->
<section class="panel">
  <header class="panel-heading">
    <h4 class="panel-title"><i class="far fa-edit"></i> Input Tanggal</h4>
  </header>
  <form id="laporanForm">
    <div class="row" style="margin:0 1px">
      <!-- Tanggal Awal -->
      <div class="col-lg-5 mb-3" style="margin:10px 0;">
        <label for="start_date" class="form-label">Tanggal Awal</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
      </div>
      <!-- Tanggal Akhir -->
      <div class="col-lg-5 mb-3" style="margin:10px 0;">
        <label for="final_date" class="form-label">Tanggal Akhir</label>
        <input type="date" class="form-control" id="final_date" name="final_date" required>
      </div>
      <!-- Filter Button -->
      <div class="col-lg-2 mb-3" style="margin:36px 0;">
        <button type="submit" class="btn btn-primary w-100" id="generate">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>
</section>
<!-- Wrapper Panel Tabel on Histori Pengeluaran Gas Medis -->
<section class="panel">
  <header class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
    <h4 class="panel-title"><i class="fas fa-table"></i> Tabel Pengeluaran Gas Medis</h4>
    <h4 class="panel-title">
      <a href="<?= base_url('keluar/insert') ?>" class="btn btn-default btn-tambah-pesanan"><i class="fa fa-plus"></i> Pengeluaran Gas Medis</a>
    </h4>
  </header>
  <!-- Table Responsive Gas Medis -->
  <div class="table-responsive" style="margin: 10px">
    <div class="export_title">Tabel Pengeluaran Gas Medis</div>
    <!-- Tabel Pengeluaran Gas Medis -->
    <table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%" id="table-export">
      <thead>
        <tr>
          <th class="text-center">Tanggal Pengeluaran</th>
          <th class="text-center">User</th>
          <th class="text-center">Detail</th>
        </tr>
      </thead>
      <tbody id="laporan-body"></tbody>
    </table>
  </div>
</section>

<script>
  // Insert Table to Our Script
  $(document).ready(function () {
    // Tanggal Awal dan Akhir
    const today = new Date();
    const sevenDaysAgo = new Date();
    sevenDaysAgo.setDate(today.getDate() - 7);
    const formatDate = (date) => date.toISOString().split("T")[0];
    $('#start_date').val(formatDate(sevenDaysAgo));
    $('#final_date').val(formatDate(today));
    // Auto Define Load Laporan
    loadLaporan();
    // Handle Trigger Event
    $('#laporanForm').submit(function (e) {
      e.preventDefault();
      loadLaporan();
    });
    // Our Main Function
    function loadLaporan() {
      const start = $('#start_date').val();
      const final = $('#final_date').val();
      // Controller
      $.ajax({
        url: "<?= base_url('keluar/historia') ?>",
        type: "GET",
        data: {start: start, final: final},
        dataType: "json",
        success: function (data) {
          const $laporanBody = $('#laporan-body');
          // Check Data & Handle Empty
          if (!data || data.length === 0) {
            const emptyRow = `
              <tr>
                <td colspan="3" class="text-center">
                  Data Pengeluaran Gas Medis Tidak Tersedia
                </td>
              </tr>`;
            $laporanBody.html(emptyRow);
            return;
          }
          // Data Available
          const createRow = (row) => {
            let actions = `
              <a href="keluar/detail/${row.id}" class="btn btn-sm btn-info" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
            `;
            // Return Complete Row
            return `
              <tr class="text-center">
                <td>${row.tanggal}</td>
                <td>${row.user}</td>
                <td>${actions}</td>
              </tr>
            `;
          };
          const allRows = data.map(row => createRow(row)).join('');
          $laporanBody.html(allRows);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          Swal.fire({
            title: 'Error !',
            html: errorThrown,
            type: 'error',
            confirmButtonText: 'OK'
          });
        }
      })
    }
  })
</script>