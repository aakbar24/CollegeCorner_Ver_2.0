<?php
$this->breadcrumbs=array(
	'Job Cats'=>array('index'),
	$model->job_cat_id=>array('view','id'=>$model->job_cat_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobCat','url'=>array('index')),
	array('label'=>'Create JobCat','url'=>array('create')),
	array('label'=>'View JobCat','url'=>array('view','id'=>$model->job_cat_id)),
	array('label'=>'Manage JobCat','url'=>array('admin')),
);
?>

<h1>Update JobCat <?php echo $model->job_cat_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>