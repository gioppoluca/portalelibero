<?php
Yii::import('application.vendor.*');
require_once('cmis/cmis-lib.php');
require_once "Alfresco/Service/Repository.php";
require_once "Alfresco/Service/Session.php";
require_once "Alfresco/Service/SpacesStore.php";

class LezioneController extends Controller
{
	private $repo_url = 'http://194.116.110.115:8080/alfresco/s/cmis';
	private $repositoryUrl = "http://194.116.110.115:8080/alfresco/api";
	private $repo_username = 'admin';
	private $repo_password = 'amanita';
	private $client;
	private $repository;

	public function actionIndex()
	{
	//	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/d3.v3.min.js',CClientScript::POS_HEAD);

		$this->render('index');
	}
	
	public function actionNodes($tag)
	{
		$this->client = new CMISService($this->repo_url, $this->repo_username, $this->repo_password);
		$this->repository = new Repository($this->repositoryUrl);
		$ticket = $this->repository->authenticate($this->repo_username, $this->repo_password);
		$objs = $this->client->query('SELECT * FROM cmis:document WHERE CONTAINS (\'TAG:'.$tag.'\')');


		$json = array('name' => $tag,'size' => 3, 'children' => array(),'img' => Yii::app()->baseUrl.'/images/Large Blackboard-24x24.png');
		$images = array('name' => 'images','size' => 1, 'children' => array(),'img' => Yii::app()->baseUrl.'/images/Image-24x24.png');
		$texts = array('name' => 'texts','size' => 1, 'children' => array(),'img' => Yii::app()->baseUrl.'/images/Notepad Block Logo-24x24.png');
		$video = array('name' => 'videos','size' => 1, 'children' => array(),'img' => Yii::app()->baseUrl.'/images/HandBrake Block Logo-24x24.png');
		
		foreach ($objs->objectList as $obj){
			error_log(print_r($obj,true));
			
			
			switch ($obj->properties['cmis:contentStreamMimeType']) {
				case 'text/plain':
				case 'application/vnd.ms-powerpoint':
				case 'application/pdf':
					$tmp = array(
						'name' => $obj->properties['cmis:name'],
						'size' => 1,
						'img' => Yii::app()->baseUrl.'/images/Notepad Block Logo-24x24.png',
						'link' => $obj->links['enclosure']."?alf_ticket=$ticket",
						'language' => 'test'
					);
					array_push($texts['children'], $tmp);
					$texts['size']=$texts['size']+1;
					break;
				case 'image/png':
					$tmp = array(
						'name' => $obj->properties['cmis:name'],
						'size' => 1,
						'img' => Yii::app()->baseUrl.'/images/Notepad Block Logo-24x24.png',
						'link' => $obj->links['enclosure']."?alf_ticket=$ticket",
						'language' => 'test'
					);
					array_push($images['children'], $tmp);
					$images['size']=$images['size']+1;
					break;
				case 'image/jpeg':
					$tmp = array(
						'name' => $obj->properties['cmis:name'],
						'size' => 1,
						'img' => Yii::app()->baseUrl.'/images/Notepad Block Logo-24x24.png',
						'link' => $obj->links['enclosure']."?alf_ticket=$ticket",
						'language' => 'test'
					);
					array_push($images['children'], $tmp);
					$images['size']=$images['size']+1;
					break;
				case 'video/x-ms-wmv':
					$tmp = array(
						'name' => $obj->properties['cmis:name'],
						'size' => 1,
						'img' => Yii::app()->baseUrl.'/images/Notepad Block Logo-24x24.png',
						'link' => $obj->links['enclosure']."?alf_ticket=$ticket",
						'language' => 'test'
					);
					array_push($video['children'], $tmp);
					$video['size']=$video['size']+1;
					break;
			}

		}
/*
		

		for ($i = 0; $i < $nodes[0]; $i++) {
		$link = $retList->entry[$i]->content->attributes()->src;
		$path = "/atom:feed/atom:entry[$i+1]/alf:icon";
		$img = $retList->xpath($path);
		$img = $img[0];
		$title = $retList->entry[$i]->title;
		$out = "<img src=\"$img\" alt=\"?\" border=\"0\" align=\"left\"  /><a href=\"$link\">$title</a><br/>";
		//    echo $out;
		//	echo $img;
		//	print_r($img[0]);
		$typ = $retList->entry[$i]->content->attributes()->type;
		//print_r($title[0]);

		switch ($typ) {
			case 'text/plain':
			case 'application/vnd.ms-powerpoint':
			case 'application/pdf':
				$tmp = array(
					'name' => ((string)$title[0]),
					'size' => 1,
					'img' => (string)$img[0],
					'link' => (string)$link[0]."?alf_ticket=$tick[0]",
					'language' => 'test'
				);
				array_push($texts['children'], $tmp);
				$texts['size']=$texts['size']+1;
				break;
			case 'image/png':
				$tmp = array(
					'name' => (string)$title[0],
					'size' => 1,
					'img' => (string)$img[0],
					'link' => (string)$link[0]."?alf_ticket=$tick[0]",
					'language' => 'test'
				);
				array_push($images['children'], $tmp);
				$images['size']=$images['size']+1;
				break;
			case 'image/jpeg':
				$tmp = array(
					'name' => (string)$title[0],
					'size' => 1,
					'img' => (string)$img[0],
					'link' => (string)$link[0]."?alf_ticket=$tick[0]",
					'language' => 'test'
				);
				array_push($images['children'], $tmp);
				$images['size']=$images['size']+1;
				break;
			case 'video/x-ms-wmv':
				$tmp = array(
					'name' => (string)$title[0],
					'size' => 1,
					'img' => (string)$img[0],
					'link' => (string)$link[0]."?alf_ticket=$tick[0]",
					'language' => 'test'
				);
				array_push($video['children'], $tmp);
				$video['size']=$video['size']+1;
				break;
		}

		}
		*/
		array_push($json['children'], $texts);
		array_push($json['children'], $images);
		array_push($json['children'], $video);
		$this->layout=false;
		header('Content-type: application/json');
		echo (CJavaScript::jsonEncode($json));
		Yii::app()->end(); 
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