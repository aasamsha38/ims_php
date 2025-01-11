<?php
$page_title = 'All sale';
require_once('includes/load.php');
page_require_level(3);
$sales = find_all_sale();

// Navigation to add_product.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_orders'])) {
	header("Location: add_orders.php");
	exit;
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-6">
		<?php echo display_msg($msg); ?>
	</div>
</div>
<div class="workboard__heading">
	<h1 class="workboard__title">Orders</h1>
</div>
<div class="workpanel report__main">
	<div class="row">
		<div class="col xs-12">
			<div class="row">
				<div class="col xs-12">
					<div class="meta-info">
						<div class="row">
							<div class="col xs-12 sm-6">
								<h2 class="subheading">Orders List</h2>
							</div>
							<div class="col xs-12 sm-6">
								<form method="POST">
									<div class="site-panel">
										<div class="form__module">
											<div class="form__action">
												<span class="icon-add"></span>
												<input type="submit" class="button primary-tint" value="Add orders" name="add_orders">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col xs-12">
								<div class="questionaries__showcase" id="question_popup" style="display: flex;">
									<div class="tbl-wrap">
										<table id="sales__table">
											<thead>
												<tr>
													<th class="S.N">S.N.</th>
													<th class="supplier">Supplier Name</th>
                                                    <th class="product">Product</th>
													<th class="reqQty">Required Qty</th>
													<th class="sentQty">Sent Qty</th>
													<th class="Date">Date</th>
													<th class="action">Action</th>
												</tr>
											</thead>
											<tbody>

												<?php foreach ($sales as $sale):?>
													<tr>
														<td class="text-center"><?php echo count_id();?></td>
                                                        <td>Supplier</td>
														<td><?php echo remove_junk($sale['name']); ?></td>
														<td class="text-center"><?php echo (int)$sale['qty']; ?></td>
														<td>sent qty</td>
														<td class="text-center"><?php echo $sale['date']; ?></td>
														<td class="text-center">
                                                        <div class="form__module">
                                                        <button type='submit'  class='btn btn-success btn-sm'>Accept</button>
                                                        <button type='submit'  class='btn btn-success btn-sm'>Decline</button>
														</td>
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
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>