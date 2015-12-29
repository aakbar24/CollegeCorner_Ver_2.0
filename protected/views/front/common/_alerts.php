<?php
if (isset($type) && isset($msg)) {
	Yii::app()->user->setFlash($type, $msg);
	$this->widget('bootstrap.widgets.TbAlert', array(
			'block'=>true, // display a larger alert block?
			'fade'=>true, // use transitions?
			'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
	));	
}