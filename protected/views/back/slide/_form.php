<?php
/** @var SlideController $this  */
/** @var TbActiveForm $form  */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'article-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<fieldset>
    <legend>
        <?php echo "Slide Image" ?>
    </legend>

    <div class="row-fluid">
        <div id="area_image" class="span12">
            <?php echo $form->fileFieldRow($model, 'slide_image'); ?>
            </div>
        </div>




    <legend>
        <?php echo "Slide Information" ?>
    </legend>


    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow($model, 'label', array('class'=>'full_width')); ?>

            <?php echo $form->textAreaRow($model, 'caption', array('class'=>'full_width')); ?>
        </div>
        <div id="area_position" class="span6">
            <?php echo $form->dropDownListRow($model, 'position',
                $this->positions); ?>
        </div>
    </div>


<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

