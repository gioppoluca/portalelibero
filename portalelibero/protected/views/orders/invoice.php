<?php
/* @var $this OrdersController */
$this->AliasNbPages();
$this->SetFont('Arial', '', 10);
$this->AddPage();
//$this->Cell(20, 10, $order->number);
//$this->Cell(20, 10, 12000);
$this->setMargins(27, 10, 15);
$this->setY(80);
//$this->writeAddress($order->customer->address, 40, 5); // helper method
//$this->writeAddress("country_name", 40, 5); // helper method

$invoiceValue = 0;
$nf = Yii::app()->getNumberFormatter();
$this->SetFillColor(255);
$this->SetTextColor(0);
/*
$this->Cell(10, 8, 'Line', 1, 0, 'C', true);
$this->Cell(20, 8, 'Catalogue #', 1, 0, 'C', true);
$this->Cell(40, 8, 'Description', 1, 0, 'C', true);
$this->Cell(20, 8, 'Unit Price', 1, 0, 'C', true);
$this->Cell(10, 8, 'Quantity', 1, 0, 'C', true);
$this->Cell(20, 8, 'Line Value', 1, 1, 'C', true);
$this->SetFillColor(255);
$this->SetTextColor(0);
$this->Image('http://retelim.local/hack1.png');
*/
foreach ($objs as $obj){
switch ($obj['mime']){
		case 'text/plain':
		$this->MultiCell(180, 8, $obj['content']->body,  0, 'L', false);
		break;
		case 'image/jpeg':
		$this->Image($obj['file']);
		@unlink($obj['file']); 

		}
}

/*
foreach ($order->lines as $i=>$line) {
  $this->setFillColor($i%2 ?255 :221); // zebra stripe the line items
  $this->Cell(10, 8, $i+1, 1, 0, 'R', true);
  $this->Cell(20, 8, $line->item->number, 1, 0, 'R', true);
  $this->Cell(40, 8, $line->item->description, 1, 0, 'L', true);
  $this->Cell(20, 8, $nf->formatCurrency($line->item->price, $currency), 1, 0, 'R', true);
  $this->Cell(10, 8, $line->quantitiy, 1, 0, 'R', true);
  $lineValue = $line->quantitiy * $line->item->price;
  $this->Cell(20, 8, $nf->formatCurrency($lineValue, $currency), 1, 1, 0, 'R', true);
  $invoiceValue += $lineValue;
}
*/
$lineValue = 12;
$this->SetFont('Arial', 'B', 10);
$this->setFillColor(170);
$this->Cell(100, 8, "Total: $invoiceValue");
//$this->Cell(20, 8, $nf->formatCurrency($lineValue, $currency), 1, 1, 0, 'R', true);
?>