<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
    array('label'=>'Manage'),
    array('label'=>'Manage Users','url'=>array('admin')),
    array('label'=>'Admin Operations'),
    array('label'=>'List User','url'=>array('index')),
    array('label'=>'Create User','url'=>array('create'),'visible'=>Yii::app()->user->isSuperAdmin()),
    array('label'=>'Create College Admin','url'=>array('createCollegeAdmin')),

    array('label'=>'Verification'),
    $this->getEmployerMenuItem(),
    $this->getStudentMenuItem(),
);
?>

<h1>Update User <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>