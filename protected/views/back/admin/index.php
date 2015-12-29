<?php
/* @var $this BackEndController */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dashboard_script.js');

$this->pageTitle=Yii::t('view', 'admin.index.title_lb');


$dataProvider=new CArrayDataProvider(Yii::app()->user->getDashboardItems($this),array(
			'id'=>'label',
			'keyField'=>'label',
		));

$this->widget('bootstrap.widgets.TbThumbnails', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}\n{pager}",
		'itemView'=>'thumbnails/_index',
));


