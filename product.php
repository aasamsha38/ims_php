<?php
$page_title = 'All Product';
require_once('includes/load.php');
page_require_level(2);
$products = join_product_table();

// Navigation to add_product.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
	header("Location: add_product.php");
	exit;
}
?>
<?php include_once('layouts/header.php'); ?>
<!-- <?php echo display_msg($msg); ?> -->
<div class="workboard__heading">
	<h1 class="workboard__title">Time Tracking</h1>
</div>
<div class="workpanel inventory__main">
	<div class="overall-info">
		<div class="row">
			<div class="col xs-12">
				<div class="info">
					<div class="row">
						<div class="col xs-12 sx-6">
							<span>Overall Inventory</span>
						</div>
						<div class="col xs-12 sx-6">
							<form method="POST">
								<div class="site-panel">
									<div class="form__action">
										<span class="icon-add"></span>
										<input type="submit" class="button primary-tint" value="Add Products" name="add_product">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="info--counter">
					<div class="row">
						<div class="col xs-12 sx-6 sm-3">
							<div class="infocounter">
								<div class="infocounter__title">
									<span class="text">Category</span>
									<a href="#"><span class="icon-ellipses"></span></a>
								</div>
								<div class="infocounter__details">
									<span class="counter">30</span>
								</div>
								<small class="text-muted">Last 24 hours</small>
							</div>
						</div>
						<div class="col xs-12 sx-6 sm-3">
							<div class="infocounter">
								<div class="infocounter__title">
									<span class="text"style="color: #fdb000;">Total Products</span>
									<a href="#"><span class="icon-ellipses"></span></a>
								</div>
								<div class="infocounter__details">
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">868</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Last 7 Days</small>
										</div>
									</div>
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">Rs.25000</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Reveneu</small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col xs-12 sx-6 sm-3">
							<div class="infocounter">
								<div class="infocounter__title">
									<span class="text" style="color: #BF40BF;" >Top Selling</span>
									<a href="#"><span class="icon-ellipses"></span></a>
								</div>
								<div class="infocounter__details">
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">5</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Last 7 Days</small>
										</div>
									</div>
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">5</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Last 7 Days</small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col xs-12 sx-6 sm-3">
							<div class="infocounter">
								<div class="infocounter__title">
									<span class="text" style="color: #C70039;">Low Stocks</span>
									<a href="#"><span class="icon-ellipses"></span></a>
								</div>
								<div class="infocounter__details">
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">12</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Ordered</small>
										</div>
									</div>
									<div class="overall-meta">
										<div class="meta-info">
											<span class="counter">2</span>
										</div>
										<div class="last_updated">
											<small class="text-muted">Not In Stock</small>
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
	<div class="meta-info">
		<div class="row">
			<div class="col xs-12">
				<form action="get">
					<div class="site-panel">
						<div class="form__module">
							<div class="form__set ">
								<span class="icon-search"></span>
								<input class="search-input" type="search" placeholder="Search">
							</div>
						</div>
						<div class="downoad">
							<a href=""><span class="icon-download"></span>Download</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col xs-12">
				<div class="questionaries__showcase" id="question_popup" style="display: flex;">
					<div class="tbl-wrap">
						<table id="tracking__table">
							<thead>
								<tr>
									<th class="dtser">Product ID</th>
									<th>Photo</th>
									<th>Product Title</th>
									<th>Category</th>
									<th>Quantity</th>
									<th>Buying Price</th>
									<th>Selling Price</th>
									<th>Product Added</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($products as $product):?>
									<tr>
										<td class="text-center"><?php echo count_id();?></td>
										<td>
											<?php if($product['media_id'] === '0'): ?>
												<img class="img-avatar img-circle profile-photo" src="uploads/products/no_image.png" alt="">
											<?php else: ?>
												<img class="img-avatar img-circle profile-photo" src="uploads/products/<?php echo $product['image']; ?>" alt="">
											<?php endif; ?>
										</td>
										<td> <?php echo remove_junk($product['name']); ?></td>
										<td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
										<td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
										<td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
										<td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
										<td class="text-center"> <?php echo read_date($product['date']); ?></td>
										<td class="text-center">
											<div class="btn-group">
												<a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
													<span class="icon-edit"></span>
												</a>
												<a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
													<span class="icon-trash"></span>
												</a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once('layouts/footer.php'); ?>