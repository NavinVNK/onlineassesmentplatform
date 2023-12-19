<?php

require_once ('vendor/autoload.php'); // Include the Composer autoloader

use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the Excel file
$spreadsheet = IOFactory::load('mswordques.xlsx');

// Select the worksheet to work with (e.g., the first worksheet)
$worksheet = $spreadsheet->getSheetByName("Sheet1");//getActiveSheet();//

// Get the cell containing the image
$imageCell = $worksheet->getCell('J2'); // Replace 'A1' with the cell containing the image

/*switch ($imageCell->getMimeType()) {
    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG :
        $extension = 'png';
        echo "PNG."; 
        break;
    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
        $extension = 'gif';
        echo "GIF"; 
        break;
    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG :
        $extension = 'jpg';
        break;
}*/

// Check if the cell contains an image
if ($imageCell->getValue() instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
    ob_start();
    call_user_func(
        $imageCell->getValue()->getRenderingFunction(),
        $imageCell->getValue()->getImageResource()
    );
    echo "Line 23."; 
    $imageContents = ob_get_contents();
    ob_end_clean();
    $image = $imageCell->getValue();
    
    // Extract the image
    $imageContents = $image->getImageResource();

    // Save the image to a file (e.g., a JPEG)
    $filename = 'extracted_image.png';
    imagejpeg($imageContents, $filename);

    echo "Image extracted and saved as $filename.";
} else {
    echo "No image found in the specified cell.";
}
