<?php 
/* @var $form TbActiveForm */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/workshop_create_script.js');

$isEmp=Yii::app()->user->isEmployer();

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workshop-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
	<legend><?php echo Yii::t('view', 'workshop.workshop_info_lb');?></legend>
	<?php echo $form->dropDownListRow($model->workshop,'workshop_cat_id',CHtml::listData(WorkshopCat::getAllCategories(), 'workshop_cat_id', 'workshop_cat_name')); ?>

	<?php if(!$isEmp):?>
		<?php echo $form->dropDownListRow($model->workshop,'workshop_facilitator_id',CHtml::listData(WorkshopFacilitator::getAllFacilitators(), 'workshop_facilitator_id', 'name'), array('empty'=>'None')); ?>
	<?php endif;?>
	
	<?php echo $form->textFieldRow($model->postItem, 'title'); ?>

	<?php //echo $form->html5EditorRow($model->postItem, 'description', array('height'=>'200px','options'=>array('useLineBreaks'=>false)));?>
	
	<?php echo $form->redactorRow($model->postItem, 'description', array(
			'height'=>'250px',
			'options'=>array(
					'source'=>false,
					'paragraph'=>true,
					'buttons'=>array(
							'formatting', '|', 'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'image', 'link', '|',
							'alignment', '|', 'horizontalrule')
					)
			)
			);?>
	<?php echo $form->hiddenField($model->postItem,'excerpt');?>

        <?php if(!$isEmp):?>
            <?php

            echo $form->typeAheadRow($model->workshop, 'company',
                array(
                'source'=>Employer::getAllCompanies(),
                'items'=>4,),
                array('class'=>'span5')
            );
            ?>
        <?php endif;?>
	
	<?php echo $form->textFieldRow($model->workshop,'website',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->fileFieldRow($model, 'workshopFile');?>

	<?php if(!$isEmp):?>
		<?php echo $form->dropDownListRow($model->workshop,'is_approved',array('1'=>'Yes','0'=>'No')); ?>
        <?php echo $form->dropDownListRow($model->workshop,'is_running',array('1'=>'Yes','0'=>'No')); ?>
	<?php endif;?>
	</fieldset>
	
	<div>
	<fieldset class="span6">
	<legend><?php echo Yii::t('view', 'workshop.location_info_lb');?></legend>
	<?php echo $form->textFieldRow($model->workshop,'address',array('class'=>'span12','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model->workshop,'city',array('class'=>'span12','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model->workshop,'province',array('class'=>'span12','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model->workshop,'postal_code',array('class'=>'span12','maxlength'=>7)); ?>

	<?php echo $form->dropDownListRow($model->workshop, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'country_id_empty'), 'class'=>'span12'));?>

	<div class="control-group">
			<?php echo $form->labelEx($model->workshop, 'phone',array('class'=>'control-label')); ?>
			<div class="controls">

				<?php $this->widget('CMaskedTextField', array('model' => $model->workshop,'attribute' => 'phone','mask' => '(999) 999-9999', 'htmlOptions'=>array('class'=>'span12')));?>
			</div>
	</div>

	<?php echo $form->textFieldRow($model->workshop,'ext',array('class'=>'span12','maxlength'=>5)); ?>
	
	</fieldset>
	
	<fieldset id="date_time" class="span6">
	<legend>
        <?php
        echo Yii::t('view', 'workshop.datetime_info_lb');
        $form->widget('bootstrap.widgets.TbButton',array(
            'label' => 'Clear',
            'type' => 'primary',
            'size' => 'small',
            'htmlOptions' => array('id' => 'clear_date_time', 'class' => 'pull-right')
        ));
        ?>
    </legend>
	<?php echo $form->datepickerRow($model->workshop,'start_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>

	<?php echo $form->datepickerRow($model->workshop,'end_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>

	<?php echo $form->timepickerRow($model->workshop,'start_time',array('class'=>'span12','prepend'=>'<i class="icon-time"></i>', 'options'=>array('defaultTime'=>false))); ?>

	<?php echo $form->timepickerRow($model->workshop,'end_time',array('class'=>'span12','prepend'=>'<i class="icon-time"></i>', 'options'=>array('defaultTime'=>false))); ?>

    <div class="control-group center-text">

    </div>
	
	</fieldset>
	<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	
	
	<?php echo $form->hiddenField($model,'form');?>
	
	<?php //echo $form->textFieldRow($model->workshop,'workshop_image',array('class'=>'span12','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->workshop->isNewRecord ? ($isEmp?'Request':'Create') : 'Update',
		)); ?>
	</div>

<?php $this->endWidget();

PostItemHelper::registerExcerptScripts('workshop-form');
/* Yii::app()->clientScript->registerScript(__FILE__.'#'.$this->getAction()->getId(),
		<<<EOD
		jQuery(document).on('submit','#workshop-form', function(e){
			var excerpt='';
			$('p',$('<div>'+$('#PostItem_description').getCode()+'</div>')).each(function(idx,value){excerpt+=$(value).text()+" ";});
			if(excerpt.length>500) excerpt=excerpt.substring(0,450);
			$('#PostItem_excerpt').val(excerpt);
		});
EOD
		,
		CClientScript::POS_READY);
?> */
?>


