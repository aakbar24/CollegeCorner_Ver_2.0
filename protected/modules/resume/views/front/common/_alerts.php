<?php
Yii::app()->user->setFlash($type, $msg);
$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'x', // close link text - if set to false, no close link is displayed
		/* 'alerts'=>array( // configurations per alert type
				'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
				'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
				'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
		), */
));