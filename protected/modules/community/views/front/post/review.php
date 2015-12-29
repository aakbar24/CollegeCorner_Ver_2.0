<?php
/* @var $this PostController */
/* @var $model PostItem */
?>

<?php 
Yii::app()->user->setFlash('success', '<strong>All done!</strong> You successfully created a new topic.');
$this->widget('bootstrap.widgets.TbAlert', array(
'block'=>true, // display a larger alert block?
'alerts'=>array( // configurations per alert type
'success'=>array('block'=>true), // success, info, warning, error or danger
),
));
?>

<br/>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		'description:html',
                'thread.program_code',
                'thread.attachment',
		'date_created',

	),
)); 

?>

<br/>

<?php

$this->widget('bootstrap.widgets.TbButton',array(
'label' => 'Back To Forum Topics',
'type' => 'primary',
'url'=>$this->createAbsoluteUrl('forum/viewTopics', array('programId'=>$model->thread->program_id, 'semesterId'=>$model->thread->semester_id))   
)); 

?>