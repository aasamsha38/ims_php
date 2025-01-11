<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$page_title = 'Add Sale';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

if (isset($_POST['add_sale'])) {
    $req_fields = array('s_id', 'quantity', 'price', 'total', 'date');
    validate_fields($req_fields);
    if (empty($errors)) {
        $p_id = $db->escape((int)$_POST['s_id']);
        $s_qty = $db->escape((int)$_POST['quantity']);
        $s_price = $db->escape($_POST['price']);
        $s_total = $db->escape($_POST['total']);
        $s_date = $db->escape($_POST['date']);

        $sql = "INSERT INTO sales (product_id, qty, price, total, date) VALUES 
        ('{$p_id}', '{$s_qty}', '{$s_price}', '{$s_total}', '{$s_date}')";

        if ($db->query($sql)) {
            update_product_qty($s_qty, $p_id);
            $session->msg('s', "Sale added successfully.");
            redirect('add_sale.php', false);
        } else {
            $session->msg('d', 'Failed to add sale!');
            redirect('add_sale.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_sale.php', false);
    }
}
if (isset($_POST['delete_sale'])) {
  $s_id = $db->escape((int)$_POST['s_id']);

  // Fetch the sale details
  $sql = "SELECT * FROM sales WHERE product_id = '{$s_id}'";
  $result = $db->query($sql);

  if ($db->num_rows($result) > 0) {
      $sale = $db->fetch_assoc($result);
      $qty_sold = $sale['qty'];

      // Delete the sale
      $delete_sql = "DELETE FROM sales WHERE product_id = '{$s_id}'";
      if ($db->query($delete_sql)) {
          // Restore the quantity in the products table
          $update_stock = "UPDATE products SET quantity = quantity + {$qty_sold} WHERE id = '{$s_id}'";
          $db->query($update_stock);

          $session->msg('s', "Sale deleted, and stock restored successfully.");
          redirect('add_sale.php', false);
      } else {
          $session->msg('d', 'Failed to delete sale!');
          redirect('add_sale.php', false);
      }
  } else {
      $session->msg('d', 'Sale not found!');
      redirect('add_sale.php', false);
  }
}


// Handle the search query
$search_query = '';
$search_result = null;
if (isset($_POST["submit"])) {
    $search_query = $db->escape($_POST["title"]);
    $sql = "SELECT 
    p.id, 
    p.name, 
    p.quantity, 
    p.sale_price, 
    p.barcode, 
    m.file_name AS image 
    FROM products p
    LEFT JOIN media m ON p.media_id = m.id
    WHERE 
    p.id = '{$search_query}' OR 
    p.name LIKE '%{$search_query}%' OR 
    p.barcode LIKE '%{$search_query}%'";
    $search_result = $db->query($sql);
}
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
<div class="workpanel inventory__main">
  <div class="meta-info">
    <div class="row">
      <div class="col xs-12">
        <form method="POST" action="add_sale.php" autocomplete="off" id="sug-form">
          <div class="site-panel">
            <div class="form__module">
              <div class="form__set">
                <button type="submit" name="submit" class="icon-search"></button>
                <input class="search-input" id="search-input" type="text" name="title" placeholder="Search">
                <ul id="suggestions" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
            </div>
            <div id="result" class="list-group"></div>
        </div>
        <div class="downoad">
          <a href=""><span class="icon-download"></span>Download</a>
      </div>
  </div>
</form>
</div>
</div>
</div>
<div class="row">
   <div class="col xs-12">
    <div class="questionaries__showcase" id="question_popup" style="display: flex;">
     <div class="tbl-wrap">
      <form method="post" action="add_sale.php">
        <table id="tracking__table">
          <thead>
            <tr>
             <th class="dtser"> Item </th>
             <th> Price </th>
             <th> Stock Qty </th>
             <th> Sell Qty </th>
             <th> Total </th>
             <th> Date </th>
             <th> Action </th>
         </tr>
     </thead>
     <tbody>
      <?php
            // Display search results
      if ($search_result && $db->num_rows($search_result) > 0) {
        while ($row = $db->fetch_assoc($search_result)) {
            echo "<tr>
            <td>{$row['name']} ({$row['barcode']})</td>
            <td>{$row['sale_price']}</td>
            <td>{$row['quantity']}</td>
            <td>
            <input type='number' name='quantity' class='sell-qty' min='1' max='{$row['quantity']}' placeholder='Enter Qty' required>
            </td>
            <td>
            <input type='text' name='total' class='total-amount' value='0' readonly>
            </td>
            <td>
            <input type='date' name='date' required>
            </td>
            <td>
            <input type='hidden' name='s_id' value='{$row['id']}'>
            <input type='hidden' name='price' value='{$row['sale_price']}'>
            <button type='submit' name='add_sale' class='btn btn-success btn-sm'>Add</button>
            <button type='submit' name='delete_sale' class='btn btn-danger btn-sm'>Delete</button>
            </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='text-center'>No products found</td></tr>";
    }
    ?>
</tbody>
</table>
</form>
</div>
</div>
</div>
</div>
<script>
    document.addEventListener('input', function(event) {
      if (event.target.classList.contains('sell-qty')) {
        const row = event.target.closest('tr');
        const price = parseFloat(row.querySelector('input[name="price"]').value);
        const quantity = parseInt(event.target.value) || 0;
        const totalField = row.querySelector('.total-amount');
        totalField.value = (price * quantity).toFixed(2);
    }
});
</script>
<?php include_once('layouts/footer.php'); ?>
