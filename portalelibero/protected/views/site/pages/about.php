<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>GioppoThis is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>
<?php
$this->widget('ext.collapsibletree.CollapsibleTree', array(
    'duration'=>500,
     'cradius'=>10,
    'data' => array(
        'name' => 'Root',
        'children' => array(
            0 => array(
                'name' => ' Level 1',
                'children' =>
                array(
                    0 => array(
                        'name' => '  Level 1.1',
                        'children' => array(
                            0 => array('name' => 'Level 1.1.1', 'size' => 3938),
                            1 => array('name' => 'Level 1.1.2', 'size' => 3812),
                            2 => array('name' => 'Level 1.1.3', 'size' => 6714),
                        ),
                    ),
                    1 => array(
                        'name' => 'Level 1.2'
                    ),
                    2 => array(
                        'name' => 'Level 1.3'
                    ),
                ),
            ),
        ),
    ),
));
?>