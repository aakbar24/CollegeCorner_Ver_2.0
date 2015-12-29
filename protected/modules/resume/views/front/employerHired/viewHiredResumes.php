<?php
/* @var $this EmployerController */
/* @var $model ViewFavorite */

$cs=Yii::app()->clientScript;
$cs->registerCssFile($this->module->getAssetsUrl().'/resume.css');
$this->pageTitle=Yii::t('view', 'employer.view_hired_resume.title_lb');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-check');
?>

<div id="alert-div"></div>
<?php 
$this->renderPartial('_viewHiredResumes',array('model'=>$model));?>

<br/>
<div class="page-header"><h3><i class="icon-time"></i> <?php echo Yii::t('view', 'employer.view_hired_resume_archive.title_lb');?></h3></div>
<?php $this->renderPartial('_viewHiredArchiveResumes',array('model'=>$model));
