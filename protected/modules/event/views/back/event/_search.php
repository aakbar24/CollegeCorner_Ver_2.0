<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'action'=>Yii::app()->createUrl($this->route),
		'type'=>'horizontal',
		'method'=>'get',
)); ?>
<fieldset>
	<legend>
		<?php echo Yii::t('view', 'event.event_info_lb')?>
	</legend>

<?php echo $form->textFieldRow($model,'post_item_id',array('class'=>'span3')); ?>

<?php echo $form->textFieldRow($model,'title',array('class'=>'span8')); ?>
<?php echo $form->textFieldRow($model,'description',array('class'=>'span12')); ?>
</fieldset>

<div class="row-fluid">
	<fieldset class="span6">
		<legend>
			<?php echo Yii::t('view', 'event.location_info_lb')?>
		</legend>
		<?php echo $form->textFieldRow($model,'address',array('class'=>'span12','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'city',array('class'=>'span12','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'province',array('class'=>'span12','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'postal_code',array('class'=>'span12','maxlength'=>7)); ?>

		<?php echo $form->textFieldRow($model,'country_id',array('class'=>'span12')); ?>

		<?php echo $form->textFieldRow($model,'phone',array('class'=>'span12','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'ext',array('class'=>'span12','maxlength'=>5)); ?>

	</fieldset>
	<fieldset class="span6">
		<legend>
			<?php echo Yii::t('view', 'event.datetime_info_lb')?>
		</legend>
		<?php echo $form->textFieldRow($model,'start_date',array('class'=>'span12')); ?>

		<?php echo $form->textFieldRow($model,'end_date',array('class'=>'span12')); ?>

		<?php echo $form->textFieldRow($model,'start_time',array('class'=>'span12')); ?>

		<?php echo $form->textFieldRow($model,'end_time',array('class'=>'span12')); ?>
	</fieldset>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
</div>

<?php $this->endWidget(); ?>
