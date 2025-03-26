<?php
//changed path to pdfThings/fpdf 
require 'hacakthon/pdfThings/fpdf.php'; // Ensure FPDF is in the "pdfThings" subdirectory

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// **Set Title**
if (isset($_GET['title'])) {
    $pdf->Cell(0, 10, $_GET['title'], 0, 1, 'C');
    $pdf->Ln(5);
}

// **Process Text Content**
if (isset($_GET['content'])) {
    $pdf->SetFont('Arial', '', 12);
    foreach ($_GET['content'] as $text) {
        $pdf->MultiCell(0, 10, utf8_decode($text), 0, 'L');
        $pdf->Ln(3);
    }
}

// **Handle Image (Download and Embed)**
if (isset($_GET['image'])) {
    $imagePath = $_GET['image'];
    $tempImage = '';

    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        // Remote Image - Download and Save Temporarily
        $imageData = @file_get_contents($imagePath);

        if ($imageData !== false) {
            $tempImage = tempnam(sys_get_temp_dir(), 'img') . '.jpg';
            file_put_contents($tempImage, $imageData);
            $pdf->Ln(5);
            $pdf->Image($tempImage, 10, $pdf->GetY(), 50); // Adjust size as needed
        } else {
            $pdf->Cell(0, 10, "❌ Could not download image: $imagePath", 0, 1);
        }
    } elseif (file_exists($imagePath)) {
        // Local Image
        $pdf->Ln(5);
        $pdf->Image($imagePath, 10, $pdf->GetY(), 50);
    } else {
        // Debugging Message
        $pdf->Cell(0, 10, "❌ Image not found: $imagePath", 0, 1);
    }
}

// **Output PDF**
// change path to easement.pdf
$pdf->Output('D', 'easement.pdf'); // Force Download
exit;
?>