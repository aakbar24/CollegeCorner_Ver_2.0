<?php 
/* @var $this Controller */
/* @var $model EventForm */
$isAdminAccess=Yii::app()->user->isAdmin()||Yii::app()->user->isSuperAdmin();

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'event-form',
		'type'=>'horizontal',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">
	Fields with <span class="required">*</span> are required.
</p>

<?php echo $form->errorSummary($model); ?>
<fieldset>
	<legend>
		<?php echo Yii::t('view', 'event.event_info_lb')?>
	</legend>
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
</fieldset>

<div class="row-fluid">
	<fieldset class="span6">
		<legend>
			<?php echo Yii::t('view', 'event.location_info_lb')?>
		</legend>
		<?php echo $form->textFieldRow($model->event,'address',array('class'=>'span12','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model->event,'city',array('class'=>'span12','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model->event,'province',array('class'=>'span12','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model->event,'postal_code',array('class'=>'span12','maxlength'=>7)); ?>

		<?php echo $form->dropDownListRow($model->event, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'country_id_empty')));?>

		<div class="control-group">
			<?php echo $form->labelEx($model->event, 'phone',array('class'=>'control-label')); ?>
			<div class="controls">

				<?php $this->widget('CMaskedTextField', array('model' => $model->event,'attribute' => 'phone','mask' => '(999) 999-9999',));?>
			</div>
		</div>

		<?php echo $form->textFieldRow($model->event,'ext',array('class'=>'span12','maxlength'=>5)); ?>
	</fieldset>

	<fieldset class="span6">
		<legend>
			<?php echo Yii::t('view', 'event.datetime_info_lb')?>
		</legend>
		<?php echo $form->datepickerRow($model->event,'start_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>

		<?php echo $form->datepickerRow($model->event,'end_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>

		<?php echo $form->timepickerRow($model->event,'start_time',array('class'=>'span12','prepend'=>'<i class="icon-time"></i>')); ?>

		<?php echo $form->timepickerRow($model->event,'end_time',array('class'=>'span12','prepend'=>'<i class="icon-time"></i>')); ?>

		<?php //echo $form->textFieldRow($model->event,'event_image',array('class'=>'span12','maxlength'=>100)); ?>

		<?php 
		if($isAdminAccess){
			if($model->event->isNewRecord || !$model->postedByCollegeAdmin()){
				echo $form->dropDownListRow($model->event, 'college_id',CHtml::listData(College::getAllCollege(),'college_id','college_name'),
						array('prompt'=>Yii::t('model', 'event.college_id_empty'),)
				);
				echo $form->hiddenField($model,'isPublic');
			}
			else{
				echo $form->checkBoxRow($model, 'isPublic',array('checked'=>$model->event->isPublic()));
			}
		}
		else{
			echo $form->checkBoxRow($model,'isPublic');
		}
		?>
		<?php echo $form->hiddenField($model,'form');?>
	</fieldset>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>

<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->event->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); 

PostItemHelper::registerExcerptScripts('event-form');
/* Yii::app()->clientScript->registerScript(__FILE__.'#'.$this->getAction()->getId(), 
<<<EOD
		jQuery(document).on('submit','#event-form', function(e){
			var excerpt='';
			$('p',$('<div>'+$('#PostItem_description').getCode()+'</div>')).each(function(idx,value){excerpt+=$(value).text()+" ";});
			if(excerpt.length>500) excerpt=excerpt.substring(0,450);
			$('#PostItem_excerpt').val(excerpt);
		});
EOD
,		
CClientScript::POS_READY); */
?>
