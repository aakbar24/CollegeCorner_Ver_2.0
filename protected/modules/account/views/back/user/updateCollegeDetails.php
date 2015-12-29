<?php
/* @var $form TbActiveForm */

$title='Update '.$collegeAdmin->college->college_name.' - College Details';
$this->pageTitle=Yii::app()->name.' >>'.$title;
$this->breadcrumbs=array(
		$title
);

?>

<h1><?php echo $title;?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'college-details-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'college_id'); ?>

	
	<div class="control-group">
		<?php echo $form->labelEx($model, 'logo_image',array('class'=>'control-label'));?>
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbUberUploadCropper',array(
					'model'=>$model,'attribute'=> 'logoImagePath',
					'existingFileAttribute'=>'logo_image','existingFileFolder'=>Yii::app()->baseUrl.'/files/images/colleges',
					'tagHtmlOptions'=>array('class'=>'span5'),
					'uploadFolder'=>Yii::app()->baseUrl.'/files/uploads/colleges',
					'uploadActionUrl'=>$this->createAbsoluteUrl('upload'),
					'cropActionUrl'=>$this->createAbsoluteUrl('crop'),
					'cropCoor'=>array(0,0,140,140),
			)
			);?>
		</div>
	</div>

	<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'province',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'postal_code',array('class'=>'span5','maxlength'=>7)); ?>

	<?php echo $form->dropDownListRow($model, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'country_id_empty')));?>

	<div class="control-group">
		<?php echo $form->labelEx($model, 'phone',array('class'=>'control-label')); ?>
		<div class="controls">
	
	<?php $this->widget('CMaskedTextField', array('model' => $model,'attribute' => 'phone','mask' => '(999) 999-9999',));?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model, 'ext');?>
	<?php echo $form->textFieldRow($model, 'website',array('type'=>'url'));?>

	<?php echo $form->colorpickerRow($model, 'event_background_color',array('events'=>array('changeColor'=>'js:function(e){$("#event-color-preview").css("background-color",e.color.toHex());}')));?>
	<?php echo $form->colorpickerRow($model, 'event_text_color',array('events'=>array('changeColor'=>'js:function(e){$("#event-color-preview").css("color",e.color.toHex());}')));?>
	<div class="control-group">
		<label class="control-label">Event color preview <br/>(color settings apply to event calendar):</label>
		<div class="controls">
			<span id="event-color-preview" class="label" style="background-color: <?php echo $model->event_background_color;?>; color:<?php echo $model->event_text_color;?>">Event
				Title </span>
		</div>
	</div>
<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); 