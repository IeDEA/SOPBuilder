<?php
    
include 'SOPBuilder-Functions.php';
require ("classes/FPDF/PDF.php");

//$_POST['xml_path'] = "definition_HICDEP161.xml";
//$_POST['criteria'] = "Test";
//$_POST['query'] = "tblBAS/*,tblLTFU/PATIENT,tblLTFU/DROP_Y,tblVIS/*";
//print_r($_POST);
$query = explode(",",$_POST['query']);

$table_array = create_array_from_xml("xml_files/".$_POST['xml_path']);
$description_text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ullamcorper in purus pulvinar accumsan. Sed id massa ultrices, posuere mi vitae, feugiat dui. Nunc in lorem urna. Nulla nec cursus sem, vitae molestie enim. Duis euismod dolor non enim consectetur, vel tempus justo faucibus. Quisque porta ac ipsum vitae bibendum. Etiam convallis augue vitae arcu fermentum ullamcorper.";
$filtered_table_array = create_filtered_table_array($table_array, $query);




$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// title
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln();
$pdf->Cell(0, 15, 'HICDEP SOP Builder Results', 0, 0, 'C');
$pdf->Ln(15);
// search query table
$pdf->SetAligns(array("R", "L"));
$pdf->SetWidths(array(80, 60));
$pdf->SetFonts(array("Times", "Times"), array("B", ""), array(10, 10));
$pdf->Row(array("Version:", $_POST['xml_path']),0);
$pdf->Row(array("Criteria:", $_POST['criteria']),0);
$pdf->Row(array("Query:", $_POST['query']),0);
$pdf->Ln(5);
// description paragraph
$pdf->SetFont('Times', '', 10);
$pdf->Write(6, $description_text);
$pdf->Ln(12);
// table
$pdf->createSOPtable($filtered_table_array);



$pdf->Output();
        