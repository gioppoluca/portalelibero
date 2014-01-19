<?php
class invoiceHelper extends PDFHelper
{
  // Header callback (called automatically by the FPDF Library)
  public function invoiceHeader()
  {
 //   $this->Image('logo.png', 10, 6, 30);
    $this->SetFont('Arial', 'B', 15);
    $this->Cell(0, 10, 'Best Widgets plc', 1, 0, 'C');
  }

  // Footer callback (called automatically by the FPDF Library)
  // $this->AliasNbPages() must have been called
  public function invoiceFooter()
  {
    $this->SetFont('Arial', 'I', 8);
    $this->SetXY(10, -15);
 //   $this->Cell(0, 6, $this->data['order']->number);
 //   $this->SetX();
 //   $this->Cell(0, 6, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
  }

  // Helper method to write an address
  public function writeAddress($address, $w, $h, $align = 'L')
  {
    static $attrs = array('extended_address', 'street_address', 'locality', 'region', 'postal_code', 'country_name');

    foreach ($attrs as $attr) {
      if (!empty($this->$address->$attr)) {
        $this->Cell($w, $h, $address->$attr, 0, 1, $align);
      }
    }
  }
}

?>