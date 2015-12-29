<?php
/* @var $this ResumePostController */
/* @var $model StudentJobTitle */
/* @var $form TbActiveForm */
?>

<div class="page-header">
	<h1>
		<?php echo Yii::t('view', 'resumePost.index_lb');?>
	</h1>
</div>

<?php 
$this->renderPartial('gridviews/_index',array('model'=>$model,'data'=>$data));
?>