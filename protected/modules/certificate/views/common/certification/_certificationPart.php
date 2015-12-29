<div class="media hero-unit cert-item-body">
<?php
if($data->cert_image)
	$image = CHtml::image($data->getCertImageUrl(), $data->title);
else
	$image=CHtml::tag('span',array('class'=>'empty-cert-image'),CHtml::tag('i',array('class'=>'icon-certificate'),'',true),true);
echo CHtml::link($image,array('view','id'=>$data->post_item_id), array('class'=>'pull-left cert-image media-object'));
?>
	<div class="media-body ">
		<div class="media posting-text">
			<?php echo (strlen(trim($data->excerpt))==0)?'<h4 class="center-text">No Description</h4>':Yii::app()->format->excerpt($data->excerpt,20);?>
		</div>
	</div>
	<?php echo CHtml::link(Yii::t('view', 'view_detail_lb'),array('view','id'=>$data->post_item_id),array('class'=>'cert-view-details'));?>
</div>