<?php
require 'class_clvr_fapi.php';
//require '../../../wp-load.php';
$downloader = new Clvr_Fapi(true);
if (!$downloader->isInitialized() || !isset($_GET['id'])){
    wp_redirect(home_url());
    exit;
}

$invoice_id = $_GET['id'];
$full_invoice = $downloader->getInvoice($invoice_id);
$filename = $full_invoice['variable_symbol'] . 'pdf';
header("Content-type:application/pdf");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename='{$filename}'");

// The PDF source is in original.pdf
readfile($downloader->getInvoicePdf($invoice_id));