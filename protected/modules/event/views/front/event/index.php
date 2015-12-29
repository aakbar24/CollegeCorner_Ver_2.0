<?php
/* @var $this Controller */
Yii::app()->clientScript->registerCssFile($this->module->getAssetsUrl().'/event.css');

$this->breadcrumbs=array('Resources','Events');

$this->tabMenus=array(
		array('label'=>'Articles', 'url'=>array('/site/articles')),
		array('label'=>'News', 'url'=>array('/site/news')),
		array('label'=>'Events', 'active'=>true,),
		array('label'=>'Workshops', 'url'=>array('//site/workshops')),
	);

$this->widget('ext.efullcalendar.EFullCalendar', array(
		//'themeCssFile'=>'cupertino/theme.css',
		'options'=>array(
			'defaultView'=>'month',
			'header'=>array(
				'left'=>'prevYear prev,next',
				'center'=>'title',
				'right'=>'today agendaDay,agendaWeek,month'
			),
			'events'=>array('url'=>$this->createAbsoluteUrl('feed'),'cache'=>true),
			'eventRender'=>'js:function(e,elem){elem.attr("title",e.signup); elem.attr("rel","tooltip").attr("data-placement","left").attr("data-container","body");}',
			'eventAfterAllRender'=>'js:function(v){ $(".fc-event[rel=tooltip]").tooltip();}'
		),
		)); 
?>

<br/>