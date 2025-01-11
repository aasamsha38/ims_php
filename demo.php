

<?php
$page_title = 'Edit Product';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
// Query to get all products, including holding cost
$query = "SELECT id, name, quantity, buy_price, sale_price, holding_cost FROM products";
$result = $db->query($query);
?>

<!-- HTML for displaying products in a table -->
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Buy Price</th>
            <th>Sale Price</th>
            <th>Holding Cost</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through all products and display them
        while ($product = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['id']) . "</td>";
            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>" . htmlspecialchars($product['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($product['buy_price']) . "</td>";
            echo "<td>" . htmlspecialchars($product['sale_price']) . "</td>";
            echo "<td>" . htmlspecialchars($product['holding_cost']) . "</td>"; // Display holding cost
            echo "<td><a href='update_product.php?id=" . $product['id'] . "'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
