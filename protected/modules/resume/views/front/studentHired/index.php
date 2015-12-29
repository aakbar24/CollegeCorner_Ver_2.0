<?php
/* @var $this Controller */
/* @var $currentHired ViewStudentJobTitle */
/* @var $previousHired ViewStudentJobTitle */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::t('view', 'studentHired.index.title_lb');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-check');
?>

<div class="page-header"><h3><i class="icon-star"></i> <?php echo Yii::t('view', 'studentHired.index.current_hired.title_lb')?></h3></div>
<?php if($currentHired==null):?>
	<p>No current hired record found.</p>
<?php else:?>
<h4><?php echo $currentHired->job_title_name;?> @ <small><?php echo CHtml::link($currentHired->company_name,'#',array('data-value'=>$currentHired->employer_id,'onclick'=>'return viewProfile(this)'));?></small></h4>


<?php $this->widget('bootstrap.widgets.TbDetailView',array(
		'type'=>array('bordered','condensed'),
		'data'=>$currentHired,
		'attributes'=>array(
					array('name'=>'job_cat_name'),
					array('name'=>'job_type_name'),
					array('name'=>'date_hired'),
					array('name'=>'resume_file',
							'type'=>'raw',
							'value'=>CHtml::link("Download Resume",$currentHired->generateResumeFileUrl()),
							),
				),
		));?>

<?php endif;?>
<br/>
<div class="page-header"><h3><i class="icon-star-empty"></i> <?php echo Yii::t('view', 'studentHired.index.previous_hired.title_lb')?></h3></div>
<?php
$this->renderPartial('gridviews/_index',array('model'=>$previousHired));
