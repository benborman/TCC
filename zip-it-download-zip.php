<?php
// Establish the zip filename
$zipItFile = $_GET['zipFile']; 

// Report an error if there is one
if(!is_readable($zipItFile)) die('File not found/unable to read it');

// As long as it exists though, add it in a header so it will download
if (file_exists($zipItFile)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zipItFile));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zipItFile));
    ob_clean();
    flush();
    readfile($zipItFile);
    exit;
}
?>