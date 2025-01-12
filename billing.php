<?php
$page_title = 'Billing';
require_once('includes/load.php');
page_require_level(3);

// Database connection
$con = mysqli_connect("localhost", "root", "", "inventory_system");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle barcode search via AJAX
if(isset($_POST['search_barcode'])) {
    $barcode = mysqli_real_escape_string($con, $_POST['search_barcode']);
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.categorie_id = c.id 
            WHERE p.barcode = '$barcode'";
    $result = mysqli_query($con, $sql);
    
    if($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $product]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
    exit;
}

// Handle payment processing
if(isset($_POST['process_payment'])) {
    $items = json_decode($_POST['items'], true);
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);
    
    mysqli_begin_transaction($con);
    try {
        foreach($items as $item) {
            $id = (int)$item['id'];
            $qty = (int)$item['quantity'];
            $price = (float)$item['price'];
            
            // Update product quantity
            $update_sql = "UPDATE products SET quantity = quantity - $qty 
                          WHERE id = $id AND quantity >= $qty";
            if(!mysqli_query($con, $update_sql)) {
                throw new Exception("Failed to update quantity");
            }
            
            // Record sale
            $sale_sql = "INSERT INTO sales (product_id, qty, price, payment_method, date) 
                        VALUES ($id, $qty, $price, '$payment_method', NOW())";
            if(!mysqli_query($con, $sale_sql)) {
                throw new Exception("Failed to record sale");
            }
        }
        
        mysqli_commit($con);
        echo json_encode(['status' => 'success']);
    } catch(Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="workboard__heading">
    <h1 class="workboard__title">Billing</h1>
</div>
<div class="workpanel sales">
    <div class="row">
        <!-- Left Panel -->
        <div class="col xs-12 sx-6">
            <div class="overall-info">
                <div class="info">
                    <div class="row">
                        <div class="col xs-12 sx-6">
                            <span>Add Product</span>
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
                <div class="col xs-12 sx-6">
                    <form class="general--form access__form info" id="product-form">
                        <div class="form__module">
                            <label for="brcode" class="form__label">Barcode</label>
                            <div class="form__set">
                                <input type="text" id="brcode" placeholder="12345" autofocus>
                            </div>
                        </div>
                        <div class="form__module">
                            <label for="prodname" class="form__label">Name</label>
                            <div class="form__set">
                                <input type="text" id="prodname" placeholder="Product Name" readonly>
                            </div>
                        </div>
                        <div class="form__module">
                            <div class="form__set">
                                <label for="mrp" class="form__label">MRP</label>
                                <input type="text" id="mrp" placeholder="Rs." readonly>
                            </div>
                        </div>
                        <div class="form__module">
                            <div class="form__set">
                                <label for="qty" class="form__label">Quantity</label>
                                <input type="text" id="qty" placeholder="Qty." value="1">
                            </div>
                        </div>
                        <div class="form__module">
                            <div class="form__set">
                                <label for="avi_qty" class="form__label">Available Quantity</label>
                                <input type="text" id="avi_qty" placeholder="Qty." readonly>
                            </div>
                        </div>
                        <div class="form__module">
                            <div class="form__set">
                                <label for="s_price" class="form__label">Sale Price</label>
                                <input type="text" id="s_price" placeholder="Rs." readonly>
                            </div>
                        </div>
                        <input type="hidden" id="product-id">
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="col xs-12 sx-6">
            <div class="overall-info">
                <div class="info">
                    <div class="row">
                        <div class="col xs-12 sx-6">
                            <span>Add Product</span>
                        </div>
                        <div class="col xs-12 sx-6">
                            <form method="POST">
                                <div class="site-panel">
                                    <div class="form__action">
                                        <input type="submit" class="button primary-tint" value="Print" name="print">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col xs-12">
                    <div class="questionaries__showcase" id="question_popup" style="display: flex;">
                        <div class="tbl-wrap">
                            <table id="cart-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col xs-12 sx-6 sm-3">
                    <form class="general--form access__form info">
                        <div class="form__module">
                            <select class="form-control" id="payment-method">
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col xs-12 sx-6 sm-3">
                    <div class="ttl_pric">
                        <span>Total</span><span id="grand-total">Rs.0.00</span>
                    </div>
                </div>
                <div class="col xs-12">
                    <form method="POST">
                        <div class="site-panel">
                            <div class="form__action">
                                <input type="button" class="button primary-tint" value="Pay" id="process-payment">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = [];
    
    // Barcode scanner handling remains the same
    document.getElementById('brcode').addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
            e.preventDefault();
            const barcode = this.value;
            
            fetch('billing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'search_barcode=' + encodeURIComponent(barcode)
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    document.getElementById('prodname').value = data.data.name;
                    document.getElementById('mrp').value = data.data.buy_price;
                    document.getElementById('s_price').value = data.data.sale_price;
                    document.getElementById('avi_qty').value = data.data.quantity;
                    document.getElementById('product-id').value = data.data.id;
                    document.getElementById('qty').focus();
                } else {
                    alert('Product not found!');
                    document.getElementById('brcode').value = '';
                }
            });
        }
    });
    
    // Add to cart button handling
    document.querySelector('input[name="add_product"]').addEventListener('click', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('product-id').value;
        if(!productId) {
            alert('Please scan a product first!');
            return;
        }

        const item = {
            id: productId,
            name: document.getElementById('prodname').value,
            unitPrice: parseFloat(document.getElementById('s_price').value),
            quantity: parseInt(document.getElementById('qty').value),
            get totalPrice() {
                return this.unitPrice * this.quantity;
            }
        };
        
        cart.push(item);
        updateCart();
        
        // Clear form
        document.getElementById('product-form').reset();
        document.getElementById('brcode').focus();
    });
    
    // Updated updateCart function to include unit price
    function updateCart() {
        const tbody = document.querySelector('#cart-table tbody');
        tbody.innerHTML = '';
        let grandTotal = 0;
        
        cart.forEach((item, index) => {
            grandTotal += item.totalPrice;
            
            const row = `
                <tr style="text-align: center;">
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>Rs.${item.unitPrice.toFixed(2)}</td>
                    <td>Rs.${item.totalPrice.toFixed(2)}</td>
                    <td class='text-center'>
                        <div class='btn-group'>
                            <a href='javascript:void(0)' onclick="removeItem(${index})" class='btn btn-danger btn-xs' title='Delete'>
                                <span class='icon-trash'></span>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
        
        document.getElementById('grand-total').textContent = 'Rs.' + grandTotal.toFixed(2);
    }
    
    // Process payment handling remains the same but update the item structure
    document.getElementById('process-payment').addEventListener('click', function() {
        if(cart.length === 0) {
            alert('Cart is empty!');
            return;
        }
        
        const paymentMethod = document.getElementById('payment-method').value;
        
        // Prepare items for backend processing
        const items = cart.map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.unitPrice // Make sure backend expects unit price
        }));
        
        fetch('billing.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'process_payment=1&items=' + encodeURIComponent(JSON.stringify(items)) + 
                  '&payment_method=' + encodeURIComponent(paymentMethod)
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Payment processed successfully!');
                cart.length = 0; // Clear cart
                updateCart();
            } else {
                alert('Error: ' + data.message);
            }
        });
    });
    
    // Global removeItem function remains the same
    window.removeItem = function(index) {
        cart.splice(index, 1);
        updateCart();
    };
});
</script>

<?php include_once('layouts/footer.php'); ?>