<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>
	<br/>
	<?php echo $form->textFieldRow($model,'post_item_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>100,'placeholder'=>'Title'));?>
	
	<?php echo $form->textFieldRow($model,'certification_cat_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'provider',array('class'=>'span5','maxlength'=>100)); ?>

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
