<?php
$page_title = 'Add Sale';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);

if (isset($_POST['add_sale'])) {
  $req_fields = array('s_id', 'quantity', 'price', 'total', 'date');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_id      = $db->escape((int)$_POST['s_id']);
    $s_qty     = $db->escape((int)$_POST['quantity']);
    $s_total   = $db->escape($_POST['total']);
    $date      = $db->escape($_POST['date']);
    $s_date    = make_date();

    $sql  = "INSERT INTO sales (";
      $sql .= " product_id,qty,price,date";
      $sql .= ") VALUES (";
      $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
      $sql .= ")";

      if ($db->query($sql)) {
        update_product_qty($s_qty, $p_id);
        $session->msg('s', "Sale added. ");
        redirect('add_sale.php', false);
      } else {
        $session->msg('d', ' Sorry failed to add!');
        redirect('add_sale.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_sale.php', false);
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
    <h1 class="workboard__title">Sales</h1>
  </div>
  <div class="workpanel inventory__main">
    <div class="meta-info">
      <div class="row">
        <div class="col xs-12">
          <form method="POST" action="ajax.php" autocomplete="off" id="sug-form">
            <div class="site-panel">
              <div class="form__module">
                <div class="form__set ">
                  <button type="submit" class="icon-search"></button>
                  <input class="search-input" type="text" name="title" placeholder="Search">
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
             <th class="dtser"> Item </th>
             <th> Price </th>
             <th> Qty </th>
             <th> Total </th>
             <th> Date</th>
             <th> Action</th>
           </thead>
           <tbody  id="product_info"> 
            <tr>
              <td>ab</td>
              <td>cd</td>
              <td>ee</td>
              <td>fg</td>
              <td>hh</td>
              <td>jj</td>
            </tr></tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

</div>


<?php include_once('layouts/footer.php'); ?>