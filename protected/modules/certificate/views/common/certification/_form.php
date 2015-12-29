<?php 
/* @var $this Controller */
/* @var $form TbActiveForm */
/* @var $model CertificationForm */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'certification-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model->postItem,'title',array('class'=>'span5','maxlength'=>100,'placeholder'=>'Title'));?>
	<?php echo $form->redactorRow($model->postItem, 'description', array(
			'height'=>'250px',
			'options'=>array(
					'source'=>true,
					'paragraph'=>true,
					'buttons'=>array(
							'formatting', '|', 'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'image', 'link', '|',
							'alignment', '|', 'horizontalrule'),
					),
			
			)			
			);?>
	<?php echo $form->hiddenField($model->postItem,'excerpt');?>
	
	
	<?php echo $form->dropDownListRow($model->certification,'certification_cat_id',CHtml::listData(CertificationCat::getAllCertCats(), 'certification_cat_id', 'certification_cat_name'),array('empty'=>'Select a category')); ?>
	
	<?php if(Yii::app()->user->isAdmin()|| Yii::app()->user->isSuperAdmin()):?>
		<?php echo $form->textFieldRow($model->certification,'provider',array('class'=>'span5','maxlength'=>100,'placeholder'=>'Provider Name'));?>
		<?php echo $form->dropDownListRow($model->certification,'provider_id',CHtml::listData(Employer::getAllEmployers(), 'user_id', 'company_name'),array('labelOptions'=>array('label'=>false),'hint'=>'Note: Select from the dropdown if the provider is a registered employer.','empty'=>'Select the employer')); ?>
	<?php elseif(Yii::app()->user->isEmployer()):?>
		<?php echo $form->hiddenField($model->certification,'provider');?>
		<?php echo $form->hiddenField($model->certification,'provider_id');?>
	<?php endif;?>
	<?php echo $form->fileFieldRow($model->certification,'cert_image',array('class'=>'span5','maxlength'=>100,'hint'=>'Note: Certification Logo or Image','placeholder'=>'Logo or Image')); ?>
	
	<?php if(!$model->certification->isNewRecord):?>
	<div class="control-group ">
		<div class="controls"><span class="label label-info"><i class="icon-info"></i> This is the current image.</span><br/><br/><a class="thumbnail"><?php echo chtml::image($model->certification->getCertImageUrl(),'certification image');?></a></div>
	</div>
	<?php endif;?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->certification->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php 
$this->endWidget(); 

PostItemHelper::registerExcerptScripts('certification-form');

Yii::app()->clientScript->registerScript(__FILE__.'#'.$this->getAction()->getId(),
		<<<EOD
		jQuery(document).on('change','#Certification_provider_id',function(e){
			var selectedProvider=$(this).find('option:selected');
			if($(this).val()!='')$('#Certification_provider').val(selectedProvider.text());
		});
EOD
		,
		CClientScript::POS_READY);
