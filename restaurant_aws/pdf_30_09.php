 <?php


/*$where = " mobile_number ='".trim($mobile_no). "'   ";
$results=$connection->get_data("customer_master","concat(fname , ' ' , lname) as name",$where,null);
foreach($results as $usrinfo)
{
	$name = ucwords($usrinfo['name']);
}*/
	$getMyOrder_exist=$connection->getMyOrder_exist($order_id);
	if(count($getMyOrder_exist) > 0)
	{

// Include the main TCPDF library (search for installation path).
require 'tcpdf/tcpdf.php';
ob_clean();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	//require_once ('db_connect.php');
	//$connection = new createConnection(); //i created a new object
	//$order_id = '10000150';

	//$name = urldecode($_GET['name']);
	$OpOrder_detail=$connection->getOpOrder_detail($order_id);
	$numItem     = count($OpOrder_detail);
	//print_r($OpOrder_detail);



// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(40, 35, 40, 45);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
			$this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
			$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Order Placed : ');
$pdf->SetTitle('');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_STRING="+91 7378845457, 7378845458";
$PDF_HEADER_TITLE='Plot No. 17, House- Sneha, Gayatri Nagar, Near IT park,  Nagpur, 440022 ';
$PDF_HEADER_LOGO= '../../../img/Zaikart_Text.png';

// set default header data
//define ('PDF_HEADER_LOGO',);
$pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

$html = '<div align="center" style="font-size:20px;font-weight:bold">INVOICE</div> ';
$html.='<div align="right">Date : '.date("d-m-Y").'</div> ';

 
if(strlen($OpOrder_detail[0]['paytm_paymentmode']) > 0)
{
	if($OpOrder_detail[0]['paytm_paymentmode'] =='NB')		
		$payment_mode =  '<br>Payment Mode : '.'Net Banking';
	if($OpOrder_detail[0]['paytm_paymentmode'] =='CC')		
		$payment_mode = '<br>Payment Mode : '.'Credit Card';
	if($OpOrder_detail[0]['paytm_paymentmode'] =='DC')		
		$payment_mode =  '<br>Payment Mode : '.'Debit Card';
	if($OpOrder_detail[0]['paytm_paymentmode'] =='PPI')		
		$payment_mode =  '<br>Payment Mode : '.'Paytm Wallet';
}

$payment_type=$OpOrder_detail[0]['payment_type'];
$free_meal=$OpOrder_detail[0]['free_meal'];
$free_credit_remain=$OpOrder_detail[0]['free_credit_remain'];
$free_meal_discount=230-$free_credit_remain;

$payment_details='';
if($payment_type=='cod')
{
	$payment_details='Payment Type : Cash on Delivery<br>';

	if($free_meal =='y')
		$payment_details.="Free Meal Discount Given";
}
elseif($payment_type=='online')
{
	$payment_details='Payment Type : PayTM<br>'.'Bank Transaction ID : '.''.$OpOrder_detail[0]['paytm_banktxnid'].'<br>Bank Name : '.''.$OpOrder_detail[0]['paytm_bankname'].''.$payment_mode.'<br>Transaction Date : '.''.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['paytm_txndate']));
	if($free_meal =='y')
		$payment_details.="Free Meal Discount Given";

}
elseif($payment_type=='free')
{
	$payment_details='Payment Type : Free Meal<br>';
		if($free_meal =='y')
		$payment_details.="Free Meal Discount Given";
}


$name = ucwords($OpOrder_detail[0]["ofname"].' '.$OpOrder_detail[0]["olname"]);



	$html.= '<table class="table table-bordered" border="1" cellpadding="5px"><tr><td><b>'.$name.'<br>'.$OpOrder_detail[0]["delivery_address1"].', '.$OpOrder_detail[0]["delivery_address2"].', '.$OpOrder_detail[0]["delivery_address3"].'<br>Pincode : '.$OpOrder_detail[0]["pincode"].'<br>Mobile No : '.$OpOrder_detail[0]["mobileno"].'<br>Email ID : '.$OpOrder_detail[0]["email_id"].'<br>Delivery Location : '.$OpOrder_detail[0]["area"].'</b></td><td>Order ID :'.$order_id.'<br>Order Placed : '.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_verify_date'])) .'<br>Delivery Requested : '.$OpOrder_detail[0]["delivery_day"].' '.$OpOrder_detail[0]["delivery_time"].'<br>'.$payment_details.'</td></tr></table><br><br>';


//$html.= "<table class='table table-bordered' border='1' cellpadding='5px'><tr><td><b>".$name."</b><br>". $OpOrder_detail[0]['delivery_address1'].", ".$OpOrder_detail[0]['delivery_address2'].", ".$OpOrder_detail[0]['delivery_address3']." - Pincode : <b>".$OpOrder_detail[0]['pincode']."</td><td>Order ID :".$order_id."<br>Order Placed : ".date('d-m-Y h:i a',strtotime($OpOrder_detail[0]['order_verify_date']))."<br>Delivery Requested : ".$OpOrder_detail[0]['delivery_day']." ".$OpOrder_detail[0]['delivery_time']."<br><br></td></tr></table>";


$html.= '<table class="table table-bordered" border="1" cellpadding="5px"><thead><tr><th  width="40px;">#</th><th width="180px;">Item Name</th><th>Quantity</th><th>Unit Price</th><th>Total Amount</th></tr></thead><tbody>';
										  
										  for ($i = 0; $i < $numItem; $i++) 
										  {
											$html.='<tr>';
											 $html.= '<td   width="40px;">'.($i+1).'</td>';
											 $html.= '<td width="180px;">';
												 $html.= $OpOrder_detail[$i]['item_name'];
												  if(strlen(trim($OpOrder_detail[$i]['detail_description'])) > 0)
													{
														
														$html.='[ <b>'.$OpOrder_detail[$i]['detail_description'].'</b> ]';
													}
												$html.= '</td>';
											
											  $html.= '<td>'.$OpOrder_detail[$i]['Qty'].'</td>';
											 $html.= '<td> <i class="fa fa-inr"></i>  '.$OpOrder_detail[$i]['SaleRate'].'</td>';
											 $html.= '<td align="right"> <i class="fa fa-inr"></i>  '.number_format($OpOrder_detail[$i]['Qty'] *$OpOrder_detail[$i]['SaleRate'], 2, '.', '') .'</td>';
											 $html.= '</tr>';     
										  }
										 $html.= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total</td><td  align="right"><i class="fa fa-inr"></i> '.'<b>'.number_format($OpOrder_detail[0]['order_amt'], 2, '.', '').'</b>'.'</td></tr>';
										 $html.= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Discount (10%)</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.number_format($OpOrder_detail[0]['order_discount'], 2, '.', '').'</b>'.'</td></tr>';
										 if($free_meal =='y')
										 {
												$html.= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Free Meal Discount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.number_format($free_meal_discount, 2, '.', '').'</b>'.'</td></tr>';
										 }

										 $html.= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Amount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.number_format($OpOrder_detail[0]['order_amt_payable'], 2, '.', '').'</b>'.'</td></tr>';
									 

									   
									  
											
										$html.= ' </tbody>	</table>';
									

// print colored table
//$pdf->ColoredTable($header, $html);

$pdf->writeHTML($html, true, false, false, false, '');

ob_end_clean();
// -------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'invoice/'.$order_id.'_invoice.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
	}