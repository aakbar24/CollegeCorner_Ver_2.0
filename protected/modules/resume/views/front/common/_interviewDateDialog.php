<?php
/*****************************A dialog for add/change the interview date****************************/
$this->beginWidget('bootstrap.widgets.TbModal',array(
		'id'=>'interview-date-modal',
		'events'=>array('hidden'=>'js:function(e){ $("#interview-date-modal #interview-resume-data").html("");$("#interview-date-modal #save-interview-date").addClass("disabled").attr("disabled",true);}')
		));?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">x</a>
	<h4>Set Interview Date/Time</h4>
</div>

<div class="modal-body">
	<div class="row-fluid">
	<div class="span6">
	<?php $this->widget('bootstrap.widgets.TbDateTimePicker',
			array(
					'inline'=>true,
					'hidden'=>true,
					'name'=>'interviewDate',
					'options'=>array(
							'showMeridian'=>true,
							'todayBtn'=>true,
							'daysOfWeekDisabled'=>array(0,6),
							'startDate'=>date("Y-m-d H:i:s"),
					),
					'events'=>array(
							'changeDate'=>'js:function(e){$("#interview-date-modal #interview-date-text").text($("#interview-date-modal #interviewDate").val()); $("#interview-date-modal #interview-date-note").html("<br/>"); $("#interview-date-modal #save-interview-date").removeClass("disabled").attr("disabled",false); }'
							),
			)
			);?>
		</div>
		<div class="span6">
			<p class="note" id="interview-date-note">No Interview Date/Time set</p>
			<h3 id="interview-date-text"></h3>
		</div>
	</div>
	<div id="interview-resume-data" class="hide"></div>
</div>

<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'type'=>'primary',
	'label'=>'Save',
	'buttonType'=>'button',
	'disabled'=>true,
	'htmlOptions'=>array('id'=>'save-interview-date'),
	
)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Close',
	'url'=>'#',
	'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
</div>

<?php $this->endWidget();

/***************************SCRIPT SECTION *************************************/

$interviewActionUrl=isset($interviewActionUrl)?$interviewActionUrl:Yii::app()->createAbsoluteUrl('resume/employerInterview/interviewSelected');
Yii::app()->clientScript->registerScript(__FILE__.'_InterviewDialog',
<<<EOD
$(document).on('click','#interview-date-modal #save-interview-date', function(){ $("#interview-date-modal #interview-date-note").text("Previous date/time set: ");  saveInterviewDates(); });		
EOD
,CClientScript::POS_READY);

Yii::app()->clientScript->registerScript(__FILE__.'_InterviewDialog_Functions',
<<<EOD
function saveInterviewDates(){
	var url='{$interviewActionUrl}';
	var data=$("#interview-date-modal input").serialize();
	$("#interview-date-modal").modal('hide');
	
	$.ajax(
		{url:url,
		type:'post',
		data:data,
		success:function(res,status,xhr){
				{$postSaveInterviewDate}
			}
		}
	);
}	
EOD
,CClientScript::POS_END);