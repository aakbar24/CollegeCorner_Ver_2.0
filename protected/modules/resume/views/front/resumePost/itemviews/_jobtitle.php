<?php
/* @var $this ResumePostController */
/* @var $data ViewStudentJobTitle */
/* @var $index integer */
/* @var $widget TbListView */
?> 
<div class="resume-details">
<?php $this->beginWidget('bootstrap.widgets.TbBox',array(
		'title'=>$data->job_title_name." ($data->job_type_name)",
		'headerIcon'=>'icon-file',
		'headerButtons'=>array(

				array('class'=>'bootstrap.widgets.TbButtonGroup',
						'buttons'=>array(
									
								array(
										'url'=>$data->generateResumeFileUrl(),
										'type'=>'primary',										//'disabled' => true,
										'label'=>Yii::t('view', 'download_lb'),										
								),//+ ($data->generatePortfolioFileUrl()== null ?									
								array(																				'url'=>$data->generatePortfolioFileUrl(),										'type'=>'primary',										'label'=>Yii::t('view', 'Pf_download_lb'),										'disabled' => false,										//'visible'=>!Yii::app()->user->isGuest,										'htmlOptions'=>array('id' => 'myid'),								),								array(																				'url'=>$data->generateResumeFileUrl(),										'type'=>'primary',										//'label'=>Yii::t('view', 'Pf_download_lb'),										'label' =>'Preview_Resume',										'disabled' => false,										//'visible'=>!Yii::app()->user->isGuest,										'htmlOptions'=>array('class' => 'Preview_Resume','onclick'=>'myFunction()'),								),								/*
								 array(
								 'url'=>$this->createUrl('editJob',array('jobTitle'=>$data->job_title_id)),
										'type'=>'warning',
										'label'=>Yii::t('view', 'form.edit_lb'),
								), */
								array(
										'buttonType'=>$data->is_hired?'button':'link',
										'url'=>$this->createUrl('deleteJob',array('stuJobID'=>$data->stu_job_id)),
										'type'=>'danger',
										'label'=>Yii::t('view', 'form.delete_lb'),
										'visible'=>count($data->interviewEmployers)==0,
										'htmlOptions'=>array('class'=>$data->is_hired?'disabled':'', 'onclick'=>'return confirm("Are you sure you want to delete this resume post?");'),
								),
								
								array(
										'url'=>Yii::app()->createAbsoluteUrl('resume/studentInterview/index'),
										'type'=>'success',
										'label'=>'# Interviews: '.count($data->interviewEmployers),
										'visible'=>count($data->interviewEmployers)>0,
										//'htmlOptions'=>array('class'=>$data->is_hired?'disabled':'', 'onclick'=>'return confirm("Are you sure you want to delete this resume post?");'),
								),
						//),						)//sss
				),

		),
		));			?>

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
					<span class="label label-info"><?php echo $skill;?> </span>
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
</dl>

<?php $this->endWidget();?>

</div>
<?php 			//$data =1; label document.getElementById('myid').innerHTML=status;		//if($data == 2)		if(empty($data->generatePortfolioFileUrl()))				{ ?>				<script type="text/javascript">				var status="No Portfolio Available";				document.getElementById('myid').disabled=true;				document.getElementById('myid').innerHTML=status;				//Preview_Resume								</script>	<?php 				}	?>	<script type="text/javascript">				//var status="No Portfolio Available";								function myFunction() {	//alert("I am an alert box!");	//$(document).ready(function() {		/* Apply fancybox to multiple items */$(document).ready(function() {		$("a.Preview_Resume").fancybox({		'width': 640, // or whatever you want		'height': 480, // or whatever you want		'type': 'iframe'		});		//});  });}</script><p><a class="Preview_Resume" href="<?php echo $data->generateResumeFileUrl()?>">Zero</a></p><script type="text/javascript">$(document).ready(function() {/* Apply fancybox to multiple items */$("a.Preview_Resume").fancybox({'width': 640, // or whatever you want'height': 480, // or whatever you want'type': 'iframe'});});  </script>