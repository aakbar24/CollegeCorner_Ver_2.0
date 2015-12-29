<?php
$this->breadcrumbs=array(
	'Job Titles'=>array('index'),
	$model->job_title_id=>array('view','id'=>$model->job_title_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobTitle','url'=>array('index')),
	array('label'=>'Create JobTitle','url'=>array('create')),
	array('label'=>'View JobTitle','url'=>array('view','id'=>$model->job_title_id)),
	array('label'=>'Manage JobTitle','url'=>array('admin')),
);
?>

<h1>Update JobTitle <?php echo $model->job_title_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>