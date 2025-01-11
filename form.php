<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IMS-Reset</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div id="wrapper">
  <div class="tpl--access">
  <main class="site__main">
    <div class="access__portal">
      <div class="main__logo">
        <img src="images/logo.svg" alt=" logo" width="155" height="60" onerror="this.onerror=null; this.src='images/logo.png'">
      </div>
      <form class="general--form access__form login__form" method="POST" action="change_password.php">
        <div class="form__module">
        <label for="supplier_name" class="form__label">Supplier Name:</label>
          <div class="form__set">
          <input type="text" id="supplier_name" name="supplier_name">
          </div>
        </div>
        <div class="form__module">
        <label for="product_name" class="form__label">Product Name:</label>
          <div class="form__set">
          <input type="text" id="product_name" name="product_name">
          </div>
        </div>
        <div class="form__module">
        <label for="required_quantity">Required Quantity:</label>
          <div class="form__set">
          <input type="number" id="required_quantity" name="required_quantity">
          </div>
        </div>
        <div class="form__module">
        <label for="sent_quantity">Sent Quantity:</label>
          <div class="form__set">
          <input type="number" id="sent_quantity" name="sent_quantity">
          </div>
        </div>
        <div class="form__action">
          <input type="hidden"  name="id" value="<?php echo (int)$user['id'];?>">
          <input type="submit" name="update" class="button primary-tint" value="Reset">
        </form>
    </div>
  </main>
</div>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>IMS-InView</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div id="wrapper">
		<main id="site__main" class="site__main inview__main">
			<section class="workboard inventorypg">
				<div class="workpanel">
					<div class="overall-info">
						<div class="row">
							<div class="col xs-12">
								<div class="info">
											<span>IMS-Vault Vision</span>
                    </div>
								<div class="row">
									<div class="col xs-12">
										<div class="horizonal--nav">
											<ul>
												<span>Send Order Details</span>
											</ul>
										</div>
									</div>
								</div>
								<div class="info--counter">
											<div class="left__panel">
												<div class="primary__details product__details">
													<div class="meta--header">
														<span >Primary Details</span>
													</div>
													<div class="listing_table product_infotable">
														<table>
															<tr>
																<th scope="row">Product name</th>
																<td>Maggi</td>
															</tr>
															<tr>
																<th scope="row">Required Qty</th>
																<td>300</td>
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
                        <div class="product__details">
													<div class="meta--header">
														<span >Sent Quantity</span>
													</div>
													<div class="col xs-12 sm-2">
              <form class="general--form access__form login__form" method="post" action="auth.php">
              <div class="form__module">
          <div class="form__set">
          <input type="tel" id="sent_quantity" name="sent_quantity">
          </div>
        </div>  
        <ul class="form__action">
          <li><input type="submit" class="button primary-tint" value="Submit"></li>
        </ul>
            </form>
              </div>
												</div>
											</div>
										</div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </main>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="test.js"></script>
</body>
</html>