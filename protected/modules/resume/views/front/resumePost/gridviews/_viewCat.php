<?php
/* @var $this ResumePostController */
/* @var $data CArrayDataProvider */
?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'ResumeIndex',
		'dataProvider' => $data,//new CArrayDataProvider($data,array('keyField'=>false)),
		'type' => 'striped bordered condensed',
		'summaryText' => false,
		'columns' => array(
				array(
						'header'=>Yii::t('model', 'jobTitle.job_title_name'),
						'name' => 'jobTitle.job_title_name',
				),

				
				

		),
));