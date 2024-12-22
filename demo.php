<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "inventory_system");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get total products count
$total_products_query = "SELECT COUNT(*) AS total_products FROM products";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total_products'];

// Get top-selling products count (You can adjust the query to your actual data structure)
$top_selling_query = "SELECT COUNT(*) AS top_selling FROM products WHERE quantity_sold > 0"; // Assuming 'quantity_sold' column
$top_selling_result = mysqli_query($con, $top_selling_query);
$top_selling_row = mysqli_fetch_assoc($top_selling_result);
$top_selling = $top_selling_row['top_selling'];

// Get low stock products count (Assuming a threshold of 5 items for low stock)
$low_stock_query = "SELECT COUNT(*) AS low_stock FROM products WHERE quantity < 5";
$low_stock_result = mysqli_query($con, $low_stock_query);
$low_stock_row = mysqli_fetch_assoc($low_stock_result);
$low_stock = $low_stock_row['low_stock'];
?>

<!-- Your HTML code for displaying the dynamic values -->
<div class="row">
    <div class="col xs-12 sm-3">
        <div class="infocounter">
            <div class="infocounter__title">
                <span class="text">Category</span>
                <a href="#"><span class="icon-ellipses"></span></a>
            </div>
            <div class="infocounter__details">
                <span class="counter"><?php echo $total_products; ?></span>
            </div>
            <small class="text-muted">Last 24 hours</small>
        </div>
    </div>
    <div class="col xs-12 sm-3">
        <div class="infocounter">
            <div class="infocounter__title">
                <span class="text" style="color: #fdb000;">Total Products</span>
                <a href="#"><span class="icon-ellipses"></span></a>
            </div>
            <div class="infocounter__details">
                <div class="overall-meta">
                    <div class="meta-info">
                        <span class="counter"><?php echo $total_products; ?></span>
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
                        <small class="text-muted">Revenue</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col xs-12 sm-3">
        <div class="infocounter">
            <div class="infocounter__title">
                <span class="text" style="color: #BF40BF;">Top Selling</span>
                <a href="#"><span class="icon-ellipses"></span></a>
            </div>
            <div class="infocounter__details">
                <div class="overall-meta">
                    <div class="meta-info">
                        <span class="counter"><?php echo $top_selling; ?></span>
                    </div>
                    <div class="last_updated">
                        <small class="text-muted">Last 7 Days</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col xs-12 sm-3">
        <div class="infocounter">
            <div class="infocounter__title">
                <span class="text" style="color: #C70039;">Low Stocks</span>
                <a href="#"><span class="icon-ellipses"></span></a>
            </div>
            <div class="infocounter__details">
                <div class="overall-meta">
                    <div class="meta-info">
                        <span class="counter"><?php echo $low_stock; ?></span>
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
