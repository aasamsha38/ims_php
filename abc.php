<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>Hello, World!</h1>');
$dompdf->render();
$dompdf->stream();
?>