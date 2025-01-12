<?php
$page_title = 'Product Details';
require_once('includes/load.php');  
// Checkin What level user has permission to view this page
page_require_level(3);

?>
<?php include_once('layouts/header.php'); ?>
    <script>
        function fetchDetails() {
            fetch("fetch_details.php")
                .then(response => response.json())
                .then(product => {
                    if (product) {
                        document.getElementById("productBarcode").textContent = product.barcode;
                        document.getElementById("productName").textContent = product.name;
                        document.getElementById("productStatus").textContent = product.status;
                        document.getElementById("productQuantity").textContent = product.quantity;
                    } else {
                        document.getElementById("productBarcode").textContent = "N/A";
                        document.getElementById("productName").textContent = "N/A";
                        document.getElementById("productStatus").textContent = "N/A";
                        document.getElementById("productQuantity").textContent = "N/A";
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        setInterval(fetchDetails, 2000); // Fetch details every 2 seconds
    </script>
				<div class="workboard__heading">
					<h1 class="workboard__title">Product Info</h1>
				</div>
				<div class="workpanel">
					<div class="overall-info">
						<div class="row">
							<div class="col xs-12">
								<div class="info">
									<div class="row">
										<div class="col xs-12 sx-6">
											<span>Maggi</span>
										</div>
										<div class="col xs-12 sx-6">
											<div class="site-panel">
												<div class="action">
													<a href=""><span class="icon-edit"></span>Edit</a>
												</div>
												<div class="action">
													<a href=""><span class="icon-download"></span>Download</a>
												</div>
												<div class="action">
													<span class="icon-close-outline"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col xs-12">
										<div class="horizonal--nav">
											<ul>
												<li><a href="view.html">Overview</a></li>
												<li><a href="inhistory.html">History</a></li>
												<li><a href="purchase.html">Purchases</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="info--counter">
									<div class="row">
										<div class="col xs-12 sx-8">
											<div class="left__panel">
												<div class="primary__details product__details">
													<div class="meta--header">
														<span >Primary Details</span>
													</div>
													<div class="listing_table product_infotable">
														<table>
															<tr>
																<th scope="row">Barcode</th>
																<td><span id="productBarcode">Waiting...</span></td>
															</tr>
															<tr>
																<th scope="row">Product ID</th>
																<td><span id="productName">Waiting...</span></td>
															</tr>
															<tr>
																<th scope="row">Product Category</th>
																<td>Instant Food</td>
															</tr>
															<tr>
																<th scope="row">Status</th>
																<td><span id="productStatus">Waiting...</span></td>
															</tr>
															<tr>
																<th scope="row">Quantity</th>
																<td><span id="productQuantity">Waiting...</span></td>
															</tr>
														</table>
													</div>
												</div>
												<div class="supplier__details product__details">
													<div class="meta--header">
														<span>Suppliers Details</span>
													</div>
													<div class="listing_table product_infotable">
														<table>
															<tr>
																<th scope="row">Supplier name</th>
																<td>Rabin Chettri</td>
															</tr>
															<tr>
																<th scope="row">Contact Number</th>
																<td>9822789400</td>
															</tr>
														</table>
													</div>
												</div>
												<div class="stock__location product__details">
													<div class="meta--header">
														<span>Stock Location</span>
													</div>
													<div class="tbl-wrap">
														<table id="tracking__table">
															<tr>
																<th scope="col">Store Name</th>
																<th scope="col">Stock in hand</th>
															</tr>
															<tr>
																<th scope="row">kathmandu Branch</th>
																<td>15</td>
															</tr>
															<tr>
																<th scope="row">Bhaktapur Branch</th>
																<td>10</td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="col xs-12 sx-6 sm-4">
											<div class="right__panel">
												<div class="profile__img">
													<div class="profile--img">
														<img src="images/img2.png" alt="profileimg" width="150px"  height="150px">
													</div>
												</div>
												<div class="tbl-wrap">
													<table id="listing__table">
														<tr>
															<th scope="row">Opening Stock</th>
															<td>40</td>
														</tr>
														<tr>
															<th scope="row">Remaning Stock</th>
															<td>34</td>
														</tr>
														<tr>
															<th scope="row">On the Way</th>
															<td>15</td>
														</tr>
														<tr>
															<th scope="row">Threshold Value</th>
															<td>12</td>
														</tr>
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
