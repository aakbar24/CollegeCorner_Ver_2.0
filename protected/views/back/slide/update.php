<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	Formatter::formatOrdinal($model->position + 1)=>array('view','id'=>$model->slide_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Slides','url'=>array('index')),
	array('label'=>'Create Slide','url'=>array('create')),
	array('label'=>'View Slides','url'=>array('view','id'=>$model->slide_id)),
	array('label'=>'Manage Slides','url'=>array('admin')),
);
?>

<h1>Update <?php echo Formatter::formatOrdinal($model->position + 1);?> Slide</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>