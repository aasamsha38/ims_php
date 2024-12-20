<?php
$page_title = 'Daily Sales';
require_once('includes/load.php');
  // Checkin What level user has permission to view this page
page_require_level(3);
?>

<?php
$year  = date('Y');
$month = date('m');
$sales = dailySales($year,$month);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-6">
		<?php echo display_msg($msg); ?>
	</div>
</div>
<div class="workboard__heading">
	<h1 class="workboard__title">Sales</h1>
</div>
<div class="workpanel report__main">
	<div class="row">
		<div class="col xs-12">
			<div class="meta-info">
				<div class="row">
					<div class="col xs-12 sm-6">
						<h2 class="subheading">Daily Sales</h2>
					</div>
				</div>
				<div class="row">
					<div class="col xs-12">
						<div class="questionaries__showcase" id="question_popup" style="display: flex;">
							<div class="tbl-wrap">
								<table id="sales__table">
									<thead>
										<tr>
											<th class="name">S.N.</th>
											<th class="name">Product Name</th>
											<th class="Quantity">Quantity</th>
											<th class="Total">Totals</th>
											<th class="Date">Date</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($sales as $sale):?>
											<tr>
												<td class="text-center"><?php echo count_id();?></td>
												<td><?php echo remove_junk($sale['name']); ?></td>
												<td class="text-center"><?php echo (int)$sale['qty']; ?></td>
												<td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
												<td class="text-center"><?php echo $sale['date']; ?></td>
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>