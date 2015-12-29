<?php
$this->breadcrumbs=array(
	'Users',
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

<h1>Users</h1>

<?php $this->widget('bootstrap.widgets.TbThumbnails',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
