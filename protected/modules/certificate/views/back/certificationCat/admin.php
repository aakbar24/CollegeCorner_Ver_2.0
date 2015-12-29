<?php
$this->breadcrumbs=array(
	'Certifications'=>array('certification/admin'),
	'Categories',
);

$this->menu=array(
	array('label'=>'Manage Certification','url'=>array('certification/admin')),
);

?>

<h1>Manage Certification Cats</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'certification-cat-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'certification_cat_id',
			array(
					'class' => 'bootstrap.widgets.TbEditableColumn',
					'name' => 'certification_cat_name',
					'sortable'=>true,
					'editable' => array(
							'url' => $this->createUrl('update'),
							'placement' => 'bottom',
							//'inputclass' => 'span3'
					)
			),
			array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{delete}',
			),
	),
)); ?>

<?php $this->renderPartial('_form', array('model'=>$createModel)); ?>
