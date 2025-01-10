<?php
$page_title = 'All Product';
require_once('includes/load.php');
page_require_level(2);
$products = join_product_table();

  // Establish database connection
$con = mysqli_connect("localhost", "root", "", "inventory_system");

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
  $upload_dir = 'uploads/products/';
  $file_name  = $_FILES['product_image']['name'];
  $file_tmp   = $_FILES['product_image']['tmp_name'];
  $file_path  = $upload_dir . $file_name;

  if (move_uploaded_file($file_tmp, $file_path)) {
    echo "File uploaded successfully!";
  } else {
    echo "Failed to move file.";
  }
}

  // Check connection
if (!$con) {
	die("Connection failed: " . mysqli_connect_error());
}

  // Navigation to add_product.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
	header("Location: add_product.php");
	exit;
}

  // Handle the search query
$search_query = '';
if (isset($_POST["submit"])) {
	$search_query = mysqli_real_escape_string($con, $_POST["title"]);
	$sql          = "SELECT products.id, products.media_id, products.name, products.date, products.quantity, products.buy_price, products.sale_price, categories.name AS categorie
	FROM products
	LEFT  JOIN categories ON products.categorie_id = categories.id
	WHERE products.id                              = '$search_query'
	OR products.name LIKE '%$search_query%' 
	OR categories.name LIKE '%$search_query%'";
	$search_result = mysqli_query($con, $sql);
} else {
	$search_result = null;
}

$last_category_update  = get_last_categories_update_time();
$last_product_update   = get_last_product_update_time();
$c_categorie           = count_by_id('categories');
$total_products_query  = "SELECT COUNT(*) AS total_products FROM products";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products_row    = mysqli_fetch_assoc($total_products_result);
$total_products        = $total_products_row['total_products'];

  // Calculate total revenue
$total_revenue_query  = "SELECT SUM(sale_price * quantity) AS total_revenue FROM products";
$total_revenue_result = mysqli_query($con, $total_revenue_query);
$total_revenue_row    = mysqli_fetch_assoc($total_revenue_result);
$total_revenue        = $total_revenue_row['total_revenue'] ?? 0;
?>

<?php include_once('layouts/header.php'); ?>
<!-- <?php echo display_msg($msg); ?> -->
<div class = "workboard__heading">
  <h1  class = "workboard__title">Billing</h1>
</div>
<div  class = "workpanel sales ">
  <div class = "row">
    <div class = "col xs-12 sx-6">
      <div class = "overall-info">
        <div class = "info">
          <div class = "row">
            <div class = "col xs-12 sx-6">
             <span>Add Product</span>
           </div>
           <div   class  = "col xs-12 sx-6">
            <form  method = "POST">
              <div   class  = "site-panel">
                <div   class  = "form__action">
                  <span  class  = "icon-add"></span>
                  <input type   = "submit" class = "button primary-tint" value = "Add Products" name = "add_product">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col xs-12 sx-6">
        <form  class = "general--form access__form info" method = "post" action= "auth.php">
          <div   class = "form__module">
            <label for   = "brcode" class = "form__label">Barcode</label>
            <div   class = "form__set">
              <input type  = "text" id= "brcode" placeholder = "12345">
            </div>
          </div>
          <div    class = "form__module">
            <label  for   = "prodname" class    = "form__label">Name</label>
            <select class = "form-control" name = "product-categorie">
              <option value = "">Select Product</option>
              <?php foreach ($all_categories as $cat): ?>
                <option value = "<?php echo (int)$cat['id'] ?>">
                  <?php echo $cat['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div   class = "form__module">
              <div   class = "form__set">
                <label for   = "brcode" class = "form__label">MRP</label>
                <input type  = "text" id = "brcode" placeholder = "Rs.">
              </div>
            </div>
            <div   class = "form__module">
              <div   class = "form__set">
                <label for   = "qty" class = "form__label">Quantity</label>
                <input type  = "text" id = "qty" placeholder = "Qty.">
              </div>
            </div>
            <div   class = "form__module">
              <div   class = "form__set">
                <label for   = "avi_qty" class = "form__label">Available Quantity</label>
                <input type  = "text" id = "avi_qty" placeholder = "Qty.">
              </div>
            </div>
            <div   class = "form__module">
              <div   class = "form__set">
                <label for   = "s_price" class = "form__label">Sale Price</label>
                <input type  = "text" id = "s_price" placeholder = "Rs.">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class = "col xs-12 sx-6">
      <div class = "overall-info">
        <div class = "info">
          <div class = "row">
            <div class = "col xs-12 sx-6">
             <span>Add Product</span>
           </div>
           <div   class  = "col xs-12 sx-6">
            <form  method = "POST">
              <div   class  = "site-panel">
                <div   class  = "form__action">
                  <input type   = "submit" class = "button primary-tint" value = "Print" name = "print">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col xs-12 ">
        <div class="questionaries__showcase" id="question_popup" style="display: flex;">
          <div class="tbl-wrap">
            <table id="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr style="text-align: center;">
                  <td>Name</td>
                  <td>Quantity</td>
                  <td>Price</td>
                  <td class='text-center'>
                    <div class='btn-group'>
                      <a href='delete_product.php?id=" . (int)$product['id'] . "' class='btn btn-danger btn-xs' title='Delete' data-toggle='tooltip'>
                        <span class='icon-trash'></span>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col xs-12 sx-6 sm-3">
        <form  class = "general--form access__form info" method = "post" action= "auth.php">
          <div    class = "form__module">
            <select class = "form-control" name = "product-categorie">
              <option value = "">Cash</option>
              <option value = "">Online</option>
            </select>
          </div>
        </form>
      </div>
      <div class="col xs-12 sx-6 sm-3">
        <div class="ttl_pric">
          <span>Total</span><span>Rs.1000</span>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>