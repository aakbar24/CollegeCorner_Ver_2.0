<?php
/* @var $this Controller */
/* @var $model ViewInterview */
?>

<?php
$ajaxUrl=$this->createAbsoluteUrl('index');
$this->widget('bootstrap.widgets.TbEnhancedExtendedGridView', array(
		'id'=>'resume-grid-view',
		'dataProvider' => $model->searchByStudent(Yii::app()->user->id),
		'type' => 'striped bordered ',
		//'responsiveTable'=>true,
		'enablePageSizeDropdown'=>true,
		'pageSizeDropdownOptions'=>array('selectedValue'=>$model->pageSize,'htmlOptions'=>array('class'=>'pageSize-dropdown')),
		//'template'=>"\n{summary}\n{items}\n{pager}",
		'filter'=>$model,
		'ajaxUrl'=> $ajaxUrl, //important! without specifiying the ajaxUrl, filtering on empty grid will fail badly

		'columns' => array(

				array(
						'header'=>"Resume ID",
						'name' => 'stu_job_id',
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
						'name'=>'interview_date',
				),
				
				array(
						'name' => 'company_name',
						'type'=>'raw',
						'value'=>'CHtml::link($data->company_name, "#",array("data-value"=>$data->employer_id,"onclick"=>new CJavaScriptExpression("return viewProfile(this)")))',
				),
				
				array(
						'class'=>'bootstrap.widgets.TbButtonColumnExtended',
						'header'=>'action',
						'dataAttr'=>array('data-stu-job-id'=>'$data->stu_job_id', 'data-from'=>'$data->student_id','data-to'=>'$data->employer_id'),
						'template'=>'{download} {cancel}',
						'buttons'=>array(
								'download'=>array('label'=>'Download Resume','icon'=>'download','url'=>'Yii::app()->createAbsoluteUrl("resume/file/download",array("name"=>$data->resume_file))'),
								'cancel'=>array('label'=>'Cancel Interview','icon'=>'remove','options'=>array('class'=>'btn-cancel-interview','onclick'=>'return cancelInterview($(this).parent());')),
								)	
				),

		),
));