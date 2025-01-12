<?php
if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    // Save barcode to a file
    file_put_contents("scanned_barcode.txt", $barcode);
    echo "Barcode saved!";
}
?>
