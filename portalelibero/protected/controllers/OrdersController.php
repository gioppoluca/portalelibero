<?php
Yii::import('application.vendor.*');
require_once('cmis/cmis-lib.php');

class OrdersController extends Controller
{
private $repo_url = 'http://194.116.110.115:8080/alfresco/s/cmis';
private $repo_username = 'admin';
private $repo_password = 'amanita';
private $repo_debug = true;

private $client;

	public function behaviors()
	{
    // This example sets the header and footer properties. If the defaults are
    // used then 'fpdf'=>'path.to.FPDFBehavior' can be used
		return array(
		  'fpdf'=>array(
			'class'=>'ext.fpdf.FPDFBehavior',
//			'fpdf'=>'path.to.FPDF.directory',
			'header'=>'invoiceHeader',
			'footer'=>'invoiceFooter'
		  )
		);
	}
	public function actionInvoice($orderId)
  {
    $this->generatePDF('invoice', array(
//      'order'=>Order::model()->with('customer, lines')->findByPk($orderId),
      'currency' => Yii::app()->params['currency']
    ));
  }
	public function actionIndex()
	{
	
	 $this->client = new CMISService($this->repo_url, $this->repo_username, $this->repo_password);
	 $objs = $this->client->query("SELECT * FROM cmis:document WHERE CONTAINS ('TAG:lezione1')");
	 $info = array();
foreach ($objs->objectList as $obj)
{
/*
    if ($obj->properties['cmis:baseTypeId'] == "cmis:document")
    {
//        print "Document: " . $obj->properties['cmis:name'] . "\n";
		$this->Cell(10, 8, $obj->properties['cmis:name'], 1, 0, 'R', true);
		$info
    }
    elseif ($obj->properties['cmis:baseTypeId'] == "cmis:folder")
    {
//        print "Folder: " . $obj->properties['cmis:name'] . "\n";
		$this->Cell(10, 8, $obj->properties['cmis:name'], 1, 0, 'R', true);
    } else
    {
//        print "Unknown Object Type: " . $obj->properties['cmis:name'] . "\n";
		$this->Cell(10, 8, $obj->properties['cmis:name'], 1, 0, 'R', true);
    }
	*/
//	switch ($obj->properties['cmis:contentStreamMimeType']){
	//	case 'text/plain':
//			echo '<iframe src="',$obj->links['enclosure'],'" height="300" width="100%"   frameborder="0"> </iframe><br/>';
//			$this->Cell(10, 8, $obj->links['enclosure'], 1, 0, 'R', true);
$content = $this->client->doRequest($obj->links['enclosure']);

$filename = "temp." . time();
if ($obj->properties['cmis:contentStreamMimeType'] == 'image/jpeg'){

$filename .= '.jpg';
   $fp = @fopen($filename, "w+");
   fwrite($fp, $content->body);
   fclose($fp);

  // $info = getimagesize($filename);

//   @unlink($filename); 
   
   }
   $info[] = array('mime'=>$obj->properties['cmis:contentStreamMimeType'],'content'=>$content,'file'=>$filename);
	//		break;
//		case 'image/jpeg':
	//	case 'image/png':
//		$the_img = $this->client->doRequest($obj->links['enclosure']);
//		$this->Image($obj->links['enclosure']);
/*
			echo '<img ',
					'class="image" ',
					'src="', $obj->links['enclosure'], '" ',
				'/><br/>';
				*/
//	}
}

		//$this->render('index');
		$this->generatePDF('invoice', array(
      'objs'=>$info,
      'currency' => Yii::app()->params['currency']
    ));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}