<?php
/* @var $form TbActiveForm */
/*****************************A dialog for add/change the interview date****************************/
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'interview-cancel-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
				
		'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validationUrl'=>Yii::app()->createAbsoluteUrl('resume/studentInterview/checkCancel'),
				)
		));
$this->beginWidget('bootstrap.widgets.TbModal',array(
		'id'=>'cancel-interview-modal',
		'events'=>array('hidden'=>'js:function(e){ document.getElementById("interview-cancel-form").reset();}')
		));?>
	
	<div class="modal-header">
		<a class="close" data-dismiss="modal">x</a>
		<h4>Send Cancel Interview Notification</h4>
	</div>
	
	<div class="modal-body">
		<div class="row-fluid">
		
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->textFieldRow($model, 'subject');?>
			<?php echo $form->html5EditorRow($model, 'body',array('class'=>'span4', 'rows'=>5, 'height'=>'300', 'options'=>array('color'=>true,'image'=>false)));?>
			<?php echo $form->hiddenField($model, 'from');?>
			<?php echo $form->hiddenField($model, 'to');?>
			<?php echo $form->hiddenField($model, 'type');?>
			<?php echo $form->hiddenField($model, 'stu_job_id');?>
			
		</div>
	</div>
	
	<div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>'Send notification',
		'buttonType'=>'submit',
		'htmlOptions'=>array('id'=>'cancel-interview'),
	)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Cancel',
		'buttonType'=>'button',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
	<?php $this->endWidget();?>
	<?php 
	
$this->endWidget();

/********SCRIPT SECTION********/
$function=<<<EOD
function openCancelInterviewDialog(stu_job_id, from, to){
	$('#cancel-interview-modal').modal('show');
	$('#interview-cancel-form #InterviewCancelForm_stu_job_id').val(stu_job_id);
	$('#interview-cancel-form #InterviewCancelForm_from').val(from);
	$('#interview-cancel-form #InterviewCancelForm_to').val(to);
} 
EOD;

$script=<<<EOD

EOD;
Yii::app()->clientScript->registerScript(__FILE__.'Functions',$function,CClientScript::POS_END);
Yii::app()->clientScript->registerScript(__FILE__.'Scripts',$script,CClientScript::POS_READY);