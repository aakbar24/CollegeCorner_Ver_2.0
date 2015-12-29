<?php

/* @var $this EmployerController */

/* @var $data ViewStudentTitle */



/* @var $widget TbListView */



$isFav=isset($data->fav_employer_id);

$isInterview=isset($data->inte_employer_id);

?>

<div id="resume-item-details<?php echo $data->stu_job_id;?>" class="resume-details well">

	<div class="row-fluid">

		<div id="resume<?php echo $data->stu_job_id;?>-alert-div"></div>

		<div class="page-header">

			

			<h4 id="resume<?php echo $data->stu_job_id;?>">

				<?php echo CHtml::checkBox('resume-item[]', false, array('id'=>'resume-item'.$data->stu_job_id, 'value'=>$data->stu_job_id,'class'=>'resume-item-checkbox'));?>

				 <?php echo CHtml::link($data->first_name.' '.$data->last_name, "#",array("data-value"=>$data->student_id,"onclick"=>new CJavaScriptExpression("return viewProfile(this)")));?>: <?php echo $data->job_title_name;?>

				<small>(<?php echo $data->job_type_name; ?>)

				</small>

				

				<?php if($isFav):?>

				<i class="icon-star fav-highlight" title="Favorited"></i>

				<?php endif;?>

				

				<?php if($isInterview):?>

				<?php echo $data->getInterviewIcon();?>

				<?php endif;?>

			</h4>

		</div>

		<div class="span8">

			<dl class="dl-horizontal">

				<dt>

					<?php echo $data->getAttributeLabel('job_cat_name');?>

				</dt>

				<dd>

					<?php echo $data->job_cat_name;?>

				</dd>

				<dt>

					<?php echo $data->getAttributeLabel('skills');?>

				</dt>

				<dd>

					<?php foreach ($data->getSkillsArray() as $skill):?>

					<span class="label label-info resume-skills"><?php echo $skill;?> </span>

					<?php endforeach;?>

				</dd>

				<dt>

					<?php echo $data->getAttributeLabel('date_created');?>

				</dt>

				<dd>

					<?php echo $data->date_created;?>

				</dd>

				<dt>

					<?php echo $data->getAttributeLabel('expiry_date');?>

				</dt>

				<dd>

					<?php echo $data->expiry_date;?>

				</dd>

				<?php if($isInterview):?>

				<dt>

					Interview Date

				</dt>

				<dd>

					<?php echo $data->employer_inte_date;?>

				</dd>

				<?php endif;?>

			</dl>



		</div>

		<div class="span3 pull-right well">

			<div class="row-fluid">

			

			<?php

			echo CHtml::beginForm($data->generateResumeFileEmployerUrl(),'POST',array('id'=>'download-resume-form'));
			

			echo CHtml::hiddenField('student_id',$data->student_id);

			echo CHtml::hiddenField('stu_job_id',$data->stu_job_id);

			echo CHtml::hiddenField('first_name',$data->first_name);

			echo CHtml::hiddenField('last_name',$data->last_name);

				$this->widget('bootstrap.widgets.TbButtonGroup', array(

						'stacked'=>true,

						'htmlOptions'=>array('class'=>'span12'),

						'buttons'=>array(

								array('label'=>'Resume',

										'block'=>true, 

										'buttonType'=>'submit',

										'icon'=>'white download-alt',

										'type'=>'primary',

										'htmlOptions'=>array(

												'class'=>'btn-block'

												)

										),

								array('label'=>'Favorite',

										'block'=>true, 

										'buttonType'=>'button', 

										'icon'=>'star', 

										'disabled'=>$isFav,

										'htmlOptions'=>array(

												//'title'=>$isFav?'Already in Favorites':'Add to Favorites',

												'data-id'=>$data->stu_job_id,

												'class'=>'btn-block fav-resume'

												)

										),

								array('label'=>'Interview',

										'block'=>true, 

										'buttonType'=>'button', 

										'icon'=>'calendar',

										'disabled'=>$isInterview,

										'htmlOptions'=>array(

												'class'=>'btn-block interview-resume',

												'data-id'=>$data->stu_job_id,

												)

										)

							),

				));

			echo CHtml::endForm();
			
			// for portfilo
			
			echo CHtml::beginForm($data->generatePortfolioFileEmployerUrl(),'POST',array('id'=>'download-resume-form'));
			

			echo CHtml::hiddenField('student_id',$data->student_id);

			echo CHtml::hiddenField('stu_job_id',$data->stu_job_id);

			echo CHtml::hiddenField('first_name',$data->first_name);

			echo CHtml::hiddenField('last_name',$data->last_name);

				$this->widget('bootstrap.widgets.TbButtonGroup', array(

						'stacked'=>true,

						'htmlOptions'=>array('class'=>'span12'),

						'buttons'=>array(

								array('label'=>'Portfolio',

										'block'=>true, 

										'buttonType'=>'submit',

										'icon'=>'white download-alt',

										'type'=>'primary',

										'htmlOptions'=>array(

												'class'=>'btn-block'

												)

										),
										)));
echo CHtml::endForm();
			?>

			</div>

		</div>

		<div class="clearfix"></div>

	</div>

</div>



<?php 

$favActionUrl=Yii::app()->createAbsoluteUrl('resume/employerFav/fav');

Yii::app()->clientScript->registerScript(__FILE__.'_Resume_Item', <<<EOD



$(document).on('click','.resume-details .fav-resume',function(e){

	var favBtn=$(this);

	var id=favBtn.data('id');

	var url='{$favActionUrl}';

	var favHtml='<i class="icon-star fav-highlight" title="Favorited"></i>';

	$.ajax({url:url,

			data:{stu_job_id:id},

			success:function(res){

					$('#resume'+id+'-alert-div').html(res);

					$('.resume-details h4#resume'+id+' small').after(favHtml);

					favBtn.addClass('disabled').attr('disabled',true);

				}

			});

});



$(document).on('click','.resume-details .interview-resume',function(e){

	var interviewBtn=$(this);

	var stuJobId=interviewBtn.data('id');

	var stuJobIdInputHtml='<input name="stu_job_id[]" type="hidden" value="'+stuJobId+'"/>';

		$('#interview-date-modal #interview-resume-data').append(stuJobIdInputHtml);

		$('#interview-date-modal').modal('show');	

	

});



EOD

		,CClientScript::POS_READY);



?>

