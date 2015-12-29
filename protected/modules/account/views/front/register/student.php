<?php
/* @var $this RegisterController */
/* @var $model StudentRegisterForm */
/* @var $user User */
/* @var $form TbActiveForm */

?>
<?php $model=new StudentRegisterForm();?>
<div class="wedge">




<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'user-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>true,
));?>

<?php echo $form->errorSummary($model); ?>
<div class="popup-header">
    <a class="close"><i class="fa fa-remove fa-lg"></i></a>

    <div>
	<h1>
		<?php echo Yii::t('view', 'registration_lb');?> <small><?php echo Yii::t('view', 'student_lb');?></small>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>
   
</div>
    <div id ="formFields">
<fieldset>
	<legend><?php echo Yii::t('view', 'account_info_lb');?></legend>
	<?php $this->renderPartial('application.modules.account.views.common.register._form',array('model'=>$model,'form'=>$form));?>
</fieldset>

<fieldset>
	<legend><?php echo Yii::t('view', 'student_info_lb');?></legend>
	<?php echo $form->dropDownListRow($model->student, 'college_id',CHtml::listData(College::model()->findAll(),'college_id','college_name'),
			array(
					'prompt'=>Yii::t('model', 'student.college_id_empty'),
					'ajax' => array(
							'type'=>'POST', //request type
							'url'=>$this->createUrl('register/ajaxCollegePrograms'), //url to call.
							'update'=>'#'.CHtml::activeId($model->student, 'program_id'), //selector to update
							'data'=>array('college'=>'js:this.value'),

					))
			);?>
<!--
	<?php echo $form->dropDownListRow($model->student, 'program_id',CHtml::listData(College::getProgramsByCollege($model->student->college_id),'program_id','program_name'),array('prompt'=>Yii::t('model', 'student.program_id_empty'),));?>
	<?php echo $form->textFieldRow($model->student, 'program_code');?>
-->
	<?php echo $form->dropDownListRow($model->student, 'education_level_id',CHtml::listData(EducationLevel::model()->findAll(),'education_level_id','education_level_name'),array('prompt'=>Yii::t('model', 'student.education_level_id_empty')));?>
	<?php echo $form->textFieldRow($model->student, 'major_name');?>
<!--
	<?php echo $form->datepickerRow($model->student, 'enrollment_date',array('options'=>array('format'=>'yyyy-mm-dd')));?>
-->

</fieldset>

<?php echo $form->checkBoxRow($model, 'consented');?>


	

<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>Yii::t('view', 'form.register_lb'),
	)); ?>
</div>
<div id="formSubmission-msg">Form Submission Status: Not Submitted</div>

<?php $this->endWidget(); ?>
</div><!-- end of form -->
</div>

<script>
$(document).ready(function()
{
	$('#user-form').submit(function(event)
	{
		event.preventDefault();
		var $form = $(this);
                 //this.validate().resetForm();
                 
                 $( document ).ajaxStart(function() {
                 $( ".formSubmissionIndicator" ).show();
                
                });
                $( document ).ajaxStop(function() {
                $( ".formSubmissionIndicator" ).hide();
                });
		$.ajax({
			url: '<?php echo Yii::app()->request->baseUrl; ?>/register/student',
			dataType: 'json',
			type: 'POST',
			data : $form.serialize()+'&ajax='+$form.attr('id'),
			success: function(data, textStatus, XMLHttpRequest)
			{           //var div1 = "#User_password_em_"
                                    $("#User_password_em_").hide();
                                    $("#User_username_em_").hide();
                                    $("#User_email_em_").hide();
                                    $("#User_first_name_em_").hide();
                                    $("#User_last_name_em_").hide();
                                    $("#StudentRegisterForm_confirmPassword_em_").hide();
                                    $("#Student_college_id_em_").hide();
                                    $("#Student_education_level_id_em_").hide();
                                    $("#StudentRegisterForm_consented_em_").hide();
				if (data != null && typeof data == 'object'){
                                    $.each(data, function(key, value) {
                                        if(key == "submit_status" && value == "sucess")
                                        {
                                             $("#formSubmission-msg").css({"background-color": "green","color": "white","font-size": "15px","padding": "15px"});
                                             $("#formSubmission-msg").text("You have submitted your registration form. Please check your email and follow the instruction");
                                             $("#user-form :input").val("");
                                             $("#user-form :input").prop('disabled', true);
                                        }
                                    var div = "#"+key+"_em_";
                                    $(div).text(value);
                                    $(div).show();
                                    //$("#simple-msg").html('<pre><code class="prettyprint">'+data+'</code></pre>');
                                });
                                }
                                
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{

			},
                        //complete: function (data) 
                        //{
                             //printWithAjax(); 
                            
                        //}
                        
		});
		return false;
	});
});
</script>

