<?php
require_once '../vendor/autoload.php';


use Sunra\PhpSimple\HtmlDomParser;


$url = "https://3kfc.co.ke/defeat-at-home-against-zetech-titans-title-race-intensifies/";

try {
    $html_content = file_get_contents($url);

    if ($html_content === false) {
        throw new Exception("Failed to fetch HTML content.");
    }

    $html = HtmlDomParser::str_get_html($html_content);

    if ($html === false) {
        throw new Exception("Failed to parse HTML content.");
    }

    // Find the image element
    $image = $html->find('img', 2); 

    if ($image) {
        
        $image_url = $image->src;
        echo "<img src='$image_url' alt=''>";
    } else {
        echo "Image not found.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
