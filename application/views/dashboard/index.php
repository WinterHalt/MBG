<!-- Total Pengeluaran Bulanan : Liquid Oxygen Satu -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Liquid Oxygen I Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardOxyCairSatu" data-value='<?php echo $liquidtu; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Liquid Oxygen Dua -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Liquid Oxygen II Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardOxyCairDua" data-value='<?php echo $liquidwa; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Oksigen -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Oksigen <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardOksigen" data-value='<?php echo $oxygen; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Nitrous Oxide -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Nitrous Oxide Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardNitroxide" data-value='<?php echo $nitroxide; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Carbon Dioxide -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Carbon Dioxide Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardCarboDioxide" data-value='<?php echo $cardioxide; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Argon -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Argon Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardArgon" data-value='<?php echo $argon; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Liquid Nitrogen -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Liquid Nitrogen Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardNitroCair" data-value='<?php echo $nitrocair; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Total Pengeluaran Bulanan : Co2MIX -->
<?php if (get_permission('dashboard', 'is_view')) { ?>
	<section class="panel bg-white shadow-sm border rounded mt-4 p-4">
		<h4 class="text-dark fw-bold mb-4" style="text-align: center;">Total Pengeluaran Bulanan Carbon Dioxide Mix Tahun <?php echo $tahun ?? date('Y'); ?></h4>
		<div style="width: 100%; height: 350px; position: relative;">
			<canvas id="myDashboardCarboDioMix" data-value='<?php echo $carbomix; ?>'></canvas>
		</div>
	</section>
<?php } ?>

<!-- Chart JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Support Script Chart JS on Bar Chart -->
<script src="<?php echo base_url('assets/js/charts.js'); ?>"></script>