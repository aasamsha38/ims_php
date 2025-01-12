<?php
// billing.php
$page_title = 'Billing';
require_once('includes/load.php');
page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>

<div class="workboard__heading">
  <h1 class="workboard__title">Billing</h1>
</div>
<div class="workpanel sales">
  <div class="row">
    <div class="col xs-12 sx-6">
      <div class="overall-info">
        <div class="info">
          <div class="row">
            <div class="col xs-12 sx-6">
              <span>Add Product</span>
            </div>
            <div class="col xs-12 sx-6">
              <form id="addProductForm" method="POST">
                <div class="site-panel">
                  <div class="form__action">
                    <span class="icon-add"></span>
                    <input type="submit" class="button primary-tint" value="Add Products">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col xs-12 sx-6">
          <form class="general--form access__form info">
            <div class="form__module">
              <label for="productBarcode" class="form__label">Barcode</label>
              <div class="form__set">
                <input type="text" id="productBarcode" name="barcode" placeholder="12345" onkeyup="fetchProductDetails()">
              </div>
            </div>
            <div class="form__module">
              <label for="productName" class="form__label">Name</label>
              <input type="text" id="productName" name="name" placeholder="Name" readonly>
            </div>
            <div class="form__module">
              <label for="qty" class="form__label">Quantity</label>
              <input type="number" id="qty" name="qty" value="1" min="1">
            </div>
            <div class="form__module">
              <label for="productStatus" class="form__label">Available</label>
              <input type="text" id="productStatus" name="status" readonly>
            </div>
            <div class="form__module">
              <label for="s_price" class="form__label">Sale Price</label>
              <input type="text" id="s_price" name="sale_price" readonly>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col xs-12 sx-6">
      <div class="overall-info">
        <div class="info">
          <div class="row">
            <div class="col xs-12 sx-6">
              <span>Receipt</span>
            </div>
            <div class="col xs-12 sx-6">
              <form id="completeSaleForm" method="POST">
                <div class="site-panel">
                  <div class="form__action">
                    <input type="submit" class="button primary-tint" value="Complete Sale">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col xs-12">
          <div class="tbl-wrap">
            <table id="receiptTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Dynamic Rows -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="col xs-12 sx-6 sm-3">
          <div class="ttl_pric">
            <span>Total:</span><span id="totalPrice">Rs.0</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Fetch product details from the server using barcode
function fetchProductDetails() {
  let barcode = document.getElementById('productBarcode').value;
  if (barcode.length > 0) {
    fetch('fetch_details.php?barcode=' + barcode)
      .then(response => response.json())
      .then(data => {
        if (data) {
          document.getElementById('productName').value = data.name;
          document.getElementById('productStatus').value = data.status;
          document.getElementById('s_price').value = data.sale_price; // Updated to sale_price
        }
      });
  }
}

// Handle Add Product to the Receipt
document.getElementById('addProductForm').addEventListener('submit', function(e) {
  e.preventDefault();
  let name = document.getElementById('productName').value;
  let qty = document.getElementById('qty').value;
  let price = document.getElementById('s_price').value;
  let total = qty * price;

  // Check if price and quantity are valid numbers
  if (isNaN(total) || total <= 0) {
    alert("Invalid price or quantity");
    return;
  }

  let table = document.getElementById('receiptTable').getElementsByTagName('tbody')[0];
  let newRow = table.insertRow();
  newRow.innerHTML = `<td>${name}</td><td>${qty}</td><td>${price}</td><td><button onclick="this.parentElement.parentElement.remove(); updateTotal();">Remove</button></td>`;
  updateTotal();
});

// Update the Total Price in the Receipt
function updateTotal() {
  let table = document.getElementById('receiptTable');
  let total = 0;

  for (let i = 0; i < table.rows.length; i++) {
    let qty = parseInt(table.rows[i].cells[1].innerText) || 0;
    let price = parseFloat(table.rows[i].cells[2].innerText) || 0;
    
    if (qty > 0 && price > 0) {
      total += qty * price;
    }
  }

  // Display the updated total price
  document.getElementById('totalPrice').innerText = 'Rs.' + total.toFixed(2);
}

// Complete Sale Form submission
document.getElementById('completeSaleForm').addEventListener('submit', function(e) {
  e.preventDefault();
  fetch('complete_sale.php', {
    method: 'POST',
    body: new FormData(this)
  }).then(response => response.text()).then(data => {
    alert('Sale Completed!');
    location.reload();
  });
});
</script>

<?php include_once('layouts/footer.php'); ?>
