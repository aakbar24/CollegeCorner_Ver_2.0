<?php
/* @var $this PostController */
/* @var $model ThreadForm */
/* @var $form bootstrap.widgets.TbActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'post-item-form',
        'type' => 'horizontal',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <fieldset>
            
            <legend>
		<?php echo Yii::t('forum', 'forum.post.postIn');?> 
            </legend>
            
        <?php echo $form->textFieldRow($model, 'collegeName', array('disabled'=>true)); ?>
            
        <?php echo $form->dropDownListRow($model->thread, 'program_id',CHtml::listData(College::getProgramsByCollege($collegeId), 'program_id','program_name'),
                array('options'=>array($this->programId=>array('selected'=>'selected')))); ?>
            
        <?php echo $form->dropDownListRow($model->thread, 'semester_id',CHtml::listData(Semester::model()->findAll(), 'semester_id','semester_name'), 
                 array('options'=>array($this->semesterId=>array('selected'=>'selected')))); ?>
            
            <?php echo $form->textFieldRow($model->thread, 'program_code'); ?>
            
            <legend>
		<?php echo Yii::t('forum', 'forum.post.details');?> 
            </legend>
            
        <?php echo $form->textFieldRow($model->postItem, 'title'); ?>
            
        <?php echo $form->html5EditorRow($model->postItem, 'description', array('height'=>'200px'));?>  
            
        <?php echo $form->fileFieldRow($model->thread, 'attachment'); ?>
            
        </fieldset>
        
        <div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Post Thread')); ?>
            
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->