<?php
$this->breadcrumbs = array(
    'Forums',
);

$this->menu = array(
    array('label' => 'Admin Operations'),
    array('label' => 'All Threads', 'url' => array('thread/admin')),
    array('label' => 'Disabled Threads', 'url' => array('thread/disabled')),
    array('label' => 'Reported Threads', 'url' => array('complaint/admin')),
    
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('thread-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->baseUrl . '/css/forum.css');
$cs->registerCssFile(Yii::app()->baseUrl . '/css/back-community.css');

$this->beginContent('//layouts/column2'); 

?>

      
<?php echo $content ?>


<?php  $this->endContent();  ?>

