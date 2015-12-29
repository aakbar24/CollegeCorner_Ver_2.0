<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Slides','url'=>array('index')),
	array('label'=>'Manage Slides','url'=>array('admin')),
);
?>

<h1>Create <?php echo Formatter::formatOrdinal(Slide::model()->count() + 1) ?> Slide</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>