<?php
/** @var ArticleController $this  */
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
    <?php echo "Article Information" ?>
    </legend>
    <?php echo $form->textFieldRow($model->postItem, 'title'); ?>

    <?php
    echo $form->redactorRow($model->postItem, 'description', array(
        'options' => array(
            'source' => false,
            'buttons' => array(
                'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                'image', 'link', '|',
                'alignment', '|', 'horizontalrule'),
            'minHeight' => 200
        ),
            )
    );
    ?>
<?php echo $form->hiddenField($model->postItem, 'excerpt'); ?>
</fieldset>

<br/>

<fieldset>
    <legend>
<?php echo "Extra Content" ?>
    </legend>
    
    <div class="row-fluid">
        <div class="span6">
           <?php echo $form->fileFieldRow($model->article, 'article_image'); ?>
            <?php echo $form->dropDownListRow($model->postItem, 'post_type_id',
                array(Article::POST_TYPE => Yii::t('model', 'article.type'), Article::POST_TYPE_NEWS => Yii::t('model', 'news.type'))); ?>
        </div>
        <div id="area_source" class="span6">
            <?php echo $form->textFieldRow($model->article, 'source', array('prepend'=>'@')); ?>
        </div>
    </div>
    
</fieldset>

<?php echo $form->hiddenField($model,'form');?>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->article->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
