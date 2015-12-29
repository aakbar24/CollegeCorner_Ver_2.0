<?php 
/* @var $this Controller */

$deleteResumesActionUrl=Yii::app()->createAbsoluteUrl('resume/employerFav/deleteSelected');

$ajaxUrl=$this->createUrl('index');
$dataProvider=$model->searchByEmployer(Yii::app()->user->id);

/* @var $this EmployerController */
/* @var $model ViewStudentJobTitle */

$this->widget('bootstrap.widgets.TbEnhancedExtendedGridView', array(
		'id'=>'resume-grid-view',
		'dataProvider' => $dataProvider,
		'type' => 'striped bordered ',
		//'responsiveTable'=>true,
		'enablePageSizeDropdown'=>true,
		'pageSizeDropdownOptions'=>array('selectedValue'=>$model->pageSize,'htmlOptions'=>array('class'=>'pageSize-dropdown')),
		//'template'=>"\n{summary}\n{items}\n{pager}",
		'filter'=>$model,
		'ajaxUrl'=> $ajaxUrl, //important! without specifiying the ajaxUrl, filtering on empty grid will fail badly
		'bulkActions' => array(

				'actionButtons' => array(
										array(
												'id'=>'btn-download-resume-zip',
												'type' => 'primary',
												'buttonType'=>'submit',
												'icon'=>'white download-alt',
												'size' => 'small',
												'label' => Yii::t('view', 'employer.resume_grid_detail.download_selected_resumes_lb'),
												'click' => 'js:function(values){submitResumeDownloadZip(values);}'
										),
										array(
												'id'=>'btn-del-resumes',
												'buttonType'=>'submit',
												'type'=>'danger',
												'icon'=>'trash',
												'size' => 'small',
												'label' => Yii::t('view', 'employer.resume_grid_detail.del_selected_resumes_lb'),
												'click' => "js:function(values){
															if(!confirm('Are you sure you want to delete all selected items?'))return false;
															$(values).attr('name','stu_job_id[]');
															var data=$(values).serialize();
															jQuery('#resume-grid-view').yiiGridView('update', {
																type: 'POST',
																url: '{$deleteResumesActionUrl}',
																data: data,
																success: function(data) {
																		$('#alert-div').html(data);
																		jQuery('#resume-grid-view').yiiGridView('update');
																},
															});
														}",
										),
									),
				// if grid doesn't have a checkbox column type, it will attach
				// one and this configuration will be part of it
				'checkBoxColumnConfig' => array(
						'name' => 'stu_job_id',
				),
		),

		'columns' => array(

				array(
						'class'=>'bootstrap.widgets.TbRelationalColumnExtended',
						'header'=>"Resume ID",
						'name' => 'stu_job_id',
						'type'=>'raw',
						'value'=> 'CHtml::tag("span",array(),$data->stu_job_id,true).
									$data->getInterviewIcon().
									$data->getExpiredIcon().
									$data->getStudentHiredIcon()
									',
						'url'=>Yii::app()->createAbsoluteUrl('resume/employer/viewResumeDetails',array('view'=>'fav')),
						'cssClassExpression'=>'"resume_id".$data->stu_job_id',
						'afterAjaxUpdate'=>'js:function(tr, rowid, data){tr.addClass("resume-detail-row");}'
				),

				array(
						'header'=>Yii::t('model', 'viewStudentJobTitle.first_name'),
						'name' => 'first_name',
						'type'=>'raw',
						'value'=>'CHtml::link($data->first_name, "#",array("data-value"=>$data->student_id,"onclick"=>new CJavaScriptExpression("return viewProfile(this)")))',
				),
				array(
						'header'=>Yii::t('model', 'viewStudentJobTitle.last_name'),
						'name' => 'last_name',
				),

				array(
						'filter'=>CHtml::listData(JobCat::getAllCategories(),'job_cat_id','job_cat_name'),
						'header'=>Yii::t('model', 'viewStudentJobTitle.job_cat_name'),
						'name' => 'job_cat_id',
						'value'=>'$data->job_cat_name',
				),
				array(
						'header'=>Yii::t('model', 'viewStudentJobTitle.job_title_name'),
						'name' => 'job_title_name',
				),

				array(
						'filter'=>CHtml::listData(College::getAllCollege(),'college_name','college_name'),
						'header'=>Yii::t('model', 'viewStudent.college_name'),
						'name'=>'college_id',
						'value'=>'$data->collegeName',
				),
					
				array(
						'name'=>'skills',
						'sortable'=>false,
						'filter'=>false,
						'header'=>Yii::t('model', 'viewStudentJobTitle.skills'),
						'type'=>'raw',
						'value'=>'"<div class=\"btn btn-mini\"><i class=\"center icon icon-info-sign\"></i></div>". CHtml::tag("div",array("id"=>"skill".$data->stu_job_id,"class"=>"hide skill-containter-div"),$data->skills)',
						'class'=>'bootstrap.widgets.TbPickerColumnExtended',
						'containerTag'=>'div',
						'containerHtmlOptions'=>array('class'=>'skills-picker-div text-center'),
						'pickerOptions' => array(
								'html'=>true,
								'title' => Yii::t('model', 'viewStudentJobTitle.skills'),
								'content' =>
								'js:function(){
									var skills=$(this).children(".skill-containter-div").text().split(",");
									var content="";
									$(skills).each(function(){content+="<span class=\"label label-info\">"+ this + "</span> ";});
									return content;
								}'
						)
				),
				array(
						'class'=>'bootstrap.widgets.TbButtonColumnExtended',
						'template'=>'{interview} {delete}',
						'id'=>'"resume-actions".$data->stu_job_id',
						'afterDelete'=>'function(link,success,data){ if(success) $("#alert-div").html(data); }',
						'buttons'=>array(
						'delete'=>array(
								'icon'=>'trash',
								'label'=>Yii::t('view', 'delete_lb'),
								'url'=>'Yii::app()->createAbsoluteUrl("resume/employerFav/delete",array("id"=>$data->stu_job_id))',
								'options'=>array('class'=>'delete-resume'),
						),
						'interview'=>array(
								'icon'=>'calendar',
								'label'=>Yii::t('view', 'interview_lb'),
								'visible'=>'$data->allowInterview()',
								'options'=>array('class'=>'interview-resume',),
						)), 
				),


		),
));



