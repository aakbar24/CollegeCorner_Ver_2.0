<?php 
/* @var $this EmployerController */
/* @var $model ViewStudentJobTitle */

$deleteResumesActionUrl=Yii::app()->createAbsoluteUrl('resume/employerHired/unhireSelected');

$ajaxUrl=$this->createUrl('index');
$dataProvider=$model->searchCurrentHiredByEmployer(Yii::app()->user->id);



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
												'id'=>'btn-unhire-resumes',
												'buttonType'=>'submit',
												'type'=>'danger',
												'icon'=>'remove',
												'size' => 'small',
												'label' => Yii::t('view', 'employer.resume_grid_detail.unhire_selected_resumes_lb'),
												'click' => "js:function(values){
															if(!confirm('Are you sure you want to un-hire all selected students?\\nNote: This cannot be undone.'))return false;
															$(values).attr('name','stu_job_id[]');
															var data=$(values).serialize();
															jQuery('#resume-grid-view').yiiGridView('update', {
																type: 'POST',
																url: '{$deleteResumesActionUrl}',
																data: data,
																success: function(data) {
																		$('#alert-div').html(data);
																		jQuery('#resume-grid-view').yiiGridView('update');
																		jQuery('#resume-grid-view-archive').yiiGridView('update');
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
									$data->getFavIcon()
									',
						'url'=>Yii::app()->createAbsoluteUrl('resume/employer/viewResumeDetails'),
						'cssClassExpression'=>'"resume_id".$data->stu_job_id',
						'cssClass'=>'tbrelational-column current-hired',
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
						'name'=>'date_hired',
						
				),
				array(
						'class'=>'bootstrap.widgets.TbButtonColumnExtended',
						'template'=>'{delete}',
						'id'=>'"resume-actions".$data->stu_job_id',
						'afterDelete'=>'function(link,success,data){ if(success) $("#alert-div").html(data); $("#resume-grid-view-archive").yiiGridView("update");}',
						'deleteConfirmation'=>"Are you sure you want to un-hire this student? \nNote: This cannot be undone.",
						'buttons'=>array(
						'delete'=>array(
								'icon'=>'remove',
								'label'=>Yii::t('view', 'unhire_lb'),
								'url'=>'Yii::app()->createAbsoluteUrl("resume/employerHired/unhire",array("stu_job_id"=>$data->stu_job_id))',
								'options'=>array('class'=>'unhire-resume'),
								'visible'=>'$data->is_current_hired=="1"',
						),
						), 
				),


		),
));



