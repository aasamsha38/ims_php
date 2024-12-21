<?php
$page_title = 'Edit Sale';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);

$sale = find_by_id('sales', (int)$_GET['id']);
if (!$sale) {
    $session->msg("d", "Missing product ID.");
    redirect('sales.php');
}

$product = find_by_id('products', $sale['product_id']);

// Handle Discard button click
if (isset($_POST['discard'])) {
    // Redirect to admin.php
    redirect('admin.php', false);
    exit; // Ensure no further code executes
}

// Handle Update Sale button click
if (isset($_POST['update_sale'])) {
    $req_fields = array('title', 'quantity', 'price', 'total', 'date');
    validate_fields($req_fields);

    if (empty($errors)) {
        $p_id = $db->escape((int)$product['id']);
        $s_qty = $db->escape((int)$_POST['quantity']);
        $s_total = $db->escape($_POST['total']);
        $date = $db->escape($_POST['date']);
        $s_date = date("Y-m-d", strtotime($date));

        $sql = "UPDATE sales SET";
        $sql .= " product_id= '{$p_id}', qty={$s_qty}, price='{$s_total}', date='{$s_date}'";
        $sql .= " WHERE id ='{$sale['id']}'";

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            update_product_qty($s_qty, $p_id);
            $session->msg('s', "Sale updated.");
            redirect('edit_sale.php?id=' . $sale['id'], false);
        } else {
            $session->msg('d', 'Sorry, failed to update!');
            redirect('sales.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_sale.php?id=' . (int)$sale['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="workboard__heading">
  <h1 class="workboard__title">Edit Sales</h1>
</div>
<div class="workpanel product__main">
  <div class="overall-info">
    <div class="row">
      <div class="col xs-12">
        <form class="general--form access__form info" method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
          <div class="info">
            <div class="row">
              <div class="col xs-12 sx-6">
                <span>Product</span>
              </div>
              <div class="col xs-12 sx-6">
                <div class="site-panel">
                  <div class="form__action">
                    <input
                    type="submit"
                    name="discard"
                    class="button tertiary-line"
                    value="Discard" />
                  </div>
                  <div class="form__action">
                    <input
                    type="submit"
                    class="button primary-tint"
                    name="update_sale"
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
                 <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo remove_junk($product['name']); ?>">
                 <div id="result" class="list-group"></div>
               </div>
             </div>
           </div>
           <div class="col xs-12 sm-3">
            <div class="form__module">
              <label for="prodthrhold" class="form__label">Sale Price</label>
              <div class="form__set">
                <input
                type="tel"
                name="price" value="<?php echo remove_junk($product['sale_price']); ?>" >
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
                name="quantity" value="<?php echo (int)$sale['qty']; ?>"
                placeholder="Product Quantity" />
              </div>
            </div>
          </div>
          <div class="col xs-12 sm-3">
            <div class="form__module">
              <label for="prodbuying" class="form__label">Total Price</label>
              <div class="form__set">
                <input
                type="tel"
                name="total" value="<?php echo remove_junk($sale['price']); ?>">
              </div>
            </div>
          </div>
          <div class="col xs-12 sm-3">
            <div class="form__module">
              <label for="buyingdate" class="form__label">Date</label>
              <div class="form__set">
                <input
                type="text"
                id="buyingdate"
                name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>">
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
