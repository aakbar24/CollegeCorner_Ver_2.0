<?php
/* @var $this ResumePostController */
/* @var $model StudentJobTitle */
/* @var $form TbActiveForm */

$this->widget('bootstrap.widgets.TbListView', array(
		'id'=>'ResumeJobCat',
		'dataProvider' => $data,//new CArrayDataProvider($data,array('keyField'=>false)),
		'summaryText'=>false,
		'itemView'=>'itemviews/_jobtitle',
));
?>