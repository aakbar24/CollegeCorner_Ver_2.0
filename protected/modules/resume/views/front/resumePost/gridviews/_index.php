<?php
/* @var $this ResumePostController */
/* @var $data CArrayDataProvider */
?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'ResumeIndex',
		'dataProvider' => $data,//new CArrayDataProvider($data,array('keyField'=>false)),
		'type' => 'striped bordered ',
		'summaryText' => false,
		'columns' => array(
				array(
						'header'=>Yii::t('model', 'jobCat.job_cat_name'),
						'name' => 'job_cat_name',
				),
				array(
						'header'=>Yii::t('view', 'resumePost.index.last_post_date_lb'),
						'name' => 'last_post',
						'type' => 'datetime'
				),
				array(
						'header'=>Yii::t('view', 'resumePost.index.count_jobs'),
						'name' => 'job_count',
				),
				
				
				array(
				 		'header' => Yii::t('view', 'form.action_lb'),
						'class' => 'bootstrap.widgets.TbButtonColumn',
						'template' => '{view}',
						'viewButtonUrl'=>'Yii::app()->controller->createUrl("viewCat",array("jobCat"=>$data["job_cat_id"]))'
				),
		),
));