<?php
if (file_exists("scanned_barcode.txt")) {
    $barcode = file_get_contents("scanned_barcode.txt");

    $conn = new mysqli("localhost", "root", "", "inventory_system");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Include sale_price in the query
    $stmt = $conn->prepare("SELECT barcode, name, status, sale_price, quantity FROM products WHERE barcode = ?");
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product); // Return the sale_price along with other details
    } else {
        echo json_encode(null); // If no product found
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(null); // If barcode.txt file is missing
}
?>
