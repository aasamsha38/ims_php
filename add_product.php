<?php
$page_title = 'Add Product';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$all_categories = find_all('categories');
$all_photo = find_all('media');

// Handle Discard button click
if (isset($_POST['discard'])) {
    // Redirect to product.php
    redirect('product.php', false);
    exit;
}

if (isset($_POST['add_product'])) {
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_name  = remove_junk($db->escape($_POST['product-title']));
    $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
    $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buying-price']));
    $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $date    = make_date();
    $query  = "INSERT INTO products (";
    $query .= " name,quantity,buy_price,sale_price,categorie_id,media_id,date";
    $query .= ") VALUES (";
    $query .= " '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}'";
    $query .= ")";
    $query .= " ON DUPLICATE KEY UPDATE name='{$p_name}'";
    if ($db->query($query)) {
      $session->msg('s', "Product added ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d', ' Sorry failed to added!');
      redirect('product.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_product.php', false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="workboard__heading">
    <h1 class="workboard__title">Products</h1>
  </div>
  <div class="workpanel inventorypg">
    <div class="overall-info">
      <div class="row">
        <div class="col xs-12">
          <form class="general--form access__form info" method="post" action="add_product.php" class="clearfix">
            <div class="info">
              <div class="row">
                <div class="col xs-12 sx-6">
                  <span>New Product</span>
                </div>
                <div class="col xs-12 sx-6">
                  <div class="site-panel">
                    <div class="form__action">
                      <input
                        type="submit"
                        class="button tertiary-line"
                        value="Discard" name="discard" />
                    </div>
                    <div class="form__action">
                      <input
                        type="submit"
                        class="button primary-tint"
                        name="add_product"
                        value="Save" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodname" class="form__label">Product Name</label>
                  <div class="form__set">
                    <input
                      type="text"
                      id="prodname"
                      name="product-title"

                      placeholder="Product Title" />
                  </div>
                </div>
              </div>
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodcat" class="form__label">Category</label>
                  <select class="form-control" name="product-categorie">
                    <option value="">Select Product Category</option>
                    <?php foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodthrhold" class="form__label">Product Photo</label>
                  <select class="form-control" name="product-photo">
                    <option value="">Select Product Photo</option>
                    <?php foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodbuying" class="form__label">Buying Price</label>
                  <div class="form__set">
                    <input
                      type="tel"
                      name="buying-price"
                      placeholder="Buying Price"
                      id="prodbuying" />
                  </div>
                </div>
              </div>
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodbuying" class="form__label">Selling Price</label>
                  <div class="form__set">
                    <input
                      type="tel"
                      id="prodbuying"
                      name="saleing-price"
                      placeholder="Selling Price" />
                  </div>
                </div>
              </div>
              <div class="col xs-12 sm-3">
                <div class="form__module">
                  <label for="prodqty" class="form__label">Quantity</label>
                  <div class="form__set">
                    <input
                      type="number"
                      id="prodqty"
                      name="product-quantity"
                      placeholder="Product Quantity" />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>