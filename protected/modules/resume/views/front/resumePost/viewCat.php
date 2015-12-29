<?php
/* @var $this ResumePostController */
/* @var $model StudentJobTitle */
/* @var $form TbActiveForm */
/* @var $jobCat JobCat */
/* @var $data CActiveDataProvider */
?>

<div class="page-header">
	<h1>
		<?php echo CHtml::link('&lsaquo;',$this->createUrl('index'),array('title'=>Yii::t('view', 'back_lb')));?>
		<?php echo Yii::t('view', 'job_titles_lb');?>
		<small>
			<?php echo $jobCat->job_cat_name;?>
		</small>
	</h1>
</div>

<?php 
$this->renderPartial('listviews/_viewCat',array('data'=>$data));
?>