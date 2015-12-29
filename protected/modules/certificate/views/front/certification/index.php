<?php
/* @var $this Controller */
/* @var $model Certification */
$this->layout='/layouts/certificationPublicLayout';
$this->breadcrumbs=array(
	'Certifications / Sponsors',
);

Yii::app()->clientScript->registerScript('search', "
		
	$('.search-form form').submit(function(){
		$.fn.yiiListView.update('certification-list', {
			data: $(this).serialize()
		});
			return false;
	});
",CClientScript::POS_READY);
?>

<h1>Certifications</h1>
<div class="search-form">
<?php $this->renderPartial('certificate.views.common.certification._certificationFilter',array('model'=>$model));?>
</div>
<?php $this->widget('bootstrap.widgets.TbThumbnails',array(
	'dataProvider'=>$model->search(true),
	'viewData'=>array('span'=>'span4'),
	'itemView'=>'certificate.views.common.certification._view',
	'id'=>'certification-list'
)); ?>
