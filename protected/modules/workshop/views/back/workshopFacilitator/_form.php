<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workshop-facilitator-form',
    'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="control-group">
    <?php echo $form->labelEx($model, 'image',array('class'=>'control-label'));?>
    <div class="controls">
        <?php
        $this->widget('bootstrap.widgets.TbUberUploadCropper',array(
                'model'=>$model,'attribute'=> 'imagePath',
                'tagHtmlOptions'=>array('class'=>'span5'),
                'uploadFolder'=>Yii::app()->baseUrl.'/files/uploads/facilitator',
                'uploadActionUrl'=>$this->createAbsoluteUrl('upload'),
                'cropActionUrl'=>$this->createAbsoluteUrl('crop'),
                'cropCoor'=>array(0,0,140,140),
            )
        );
        ?>
    </div>
</div>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textAreaRow($model,'biography',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
