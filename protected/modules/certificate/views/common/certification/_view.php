<li class="<?php echo $span;?>">
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->post_item_id)).CertificationHelper::getCertficationCatLabel($data),
	//'headerIcon' => 'icon-user',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'thumbnail certification')
));?>
<div class="view">

	<?php 
	$this->renderPartial('certificate.views.common.certification._certificationPart',array('data'=>$data,'span'=>$span));
	?>
</div>

<?php $this->endWidget();?>
</li>