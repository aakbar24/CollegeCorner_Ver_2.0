<?php
$this->breadcrumbs=array(
	'Certifications',
);

$this->menu=array(
	array('label'=>'Create Certification','url'=>array('create')),
	array('label'=>'Manage Certification','url'=>array('admin')),
);
?>

<h1>Certifications</h1>

<?php $this->widget('bootstrap.widgets.TbThumbnails',array(
	'dataProvider'=>$dataProvider,
	'viewData'=>array('span'=>'span6'),
	'itemView'=>'certificate.views.common.certification._view',
)); ?>
