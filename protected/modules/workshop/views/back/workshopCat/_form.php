<?php 
/* @var $model WorkshopCat */
?>
<div class="page-header"><h3>Create new category</h3></div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workshop-cat-form',
	'type'=>'vertical',
	'inlineErrors'=>false,
	//'enableClientValidation'=>true,
	'action'=>'create',
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>

	<?php echo $form->textFieldRow($model,'workshop_cat_name',array('class'=>'span5','maxlength'=>45,'placeHolder'=>$model->getAttributeLabel('workshop_cat_name'),)); ?>

	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	<br/>
<?php $this->endWidget(); ?>
