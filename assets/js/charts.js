// Pengaturan & Variable Data Medical Gases
const dashboardCharts = [
  { id: 'myDashboardOxyCairSatu', border: '#FFE2E2', point: '#E8A9A9', satuan: 'Meter Kubik' },
  { id: 'myDashboardOxyCairDua', border: '#FE81D4', point: '#D454A8', satuan: 'Meter Kubik' },
  { id: 'myDashboardOksigen', border: '#A0B8D8', point: '#6090B8', satuan: 'Tabung' },
  { id: 'myDashboardNitroxide', border: '#9B87C4', point: '#7259A3', satuan: 'Tabung' },
  { id: 'myDashboardCarboDioxide', border: '#D9B44A', point: '#B8912E', satuan: 'Tabung' },
  { id: 'myDashboardArgon', border: '#A8C5A0', point: '#70A070', satuan: 'Tabung' },
  { id: 'myDashboardNitroCair', border: '#E08B6F', point: '#C15F3F', satuan: 'Liter' },
  { id: 'myDashboardCarboDioMix', border: '#8A93A6', point: '#5F6A80', satuan: 'Meter Kubik' }
];

// Konversi Nilai Hex to Red Green Blue Alpha Untuk Kebutuhan Coloring Gradient
function hexToRgba(hex, alpha) {
  const r = parseInt(hex.slice(1, 3), 16);
  const g = parseInt(hex.slice(3, 5), 16);
  const b = parseInt(hex.slice(5, 7), 16);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// Fungsi Generic Untuk Render 1 Chart, Dipanggil Berulang Lewat Loop Di Bawah
function renderGasChart(config) {
  // Content of Java Script Plot
  const chartElement = document.getElementById(config.id);
  // Skip Kalau Elemen Tidak Ada Di Halaman (Misal Karena Permission User Tidak Muncul)
  if (!chartElement) return;
  // Ambil Context Dua Dimensi
  const ctx = chartElement.getContext('2d');
  // Nilai Dalam Data Value
  const valueData = JSON.parse(chartElement.getAttribute('data-value'));
  // Coloring Gradient
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, hexToRgba(config.border, 0.6));
  gradient.addColorStop(1, hexToRgba(config.border, 0.0));

  // Define Chart & Set
  new Chart(ctx, {
    // Type Plot
    type: 'line',
    data: {
      // Monthly
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      // Define Dataset & Custom Config
      datasets: [{
        label: 'Jumlah ' + config.satuan,
        data: valueData,
        fill: true,
        backgroundColor: gradient,
        borderColor: config.border,
        borderWidth: 3,
        tension: 0.4,
        pointRadius: 5,
        pointHoverRadius: 8,
        pointBackgroundColor: config.point,
        pointBorderColor: '#fff',
        pointBorderWidth: 2
      }]
    },
    // Define Pilihan
    options: {
      responsive: true,
      maintainAspectRatio: false,
      // Plugin
      plugins: {
        legend: { display: false }
      },
      // Skala
      scales: {
        // Pengaturan Vertikal Plot
        y: {
          beginAtZero: true,
          // Jarak Antar Nilai 10 & Bilangan Bulat & Satuan Masing Masing Variable
          ticks: { stepSize: 10, precision: 0 },
          // Title
          title: {
            display: true,
            text: 'Jumlah ' + config.satuan,
            font: { weight: 'bold', size: 12 }
          },
          grid: { color: 'rgba(0, 0, 0, 0.05)' }
        },
        // Pengaturan Horizontal Plot
        x: {
          title: { display: true, text: 'Bulan' }
        }
      }
    }
  });
}

// Jalankan Semua Chart Sekaligus
dashboardCharts.forEach(renderGasChart);