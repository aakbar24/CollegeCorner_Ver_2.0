<?php
/* @var $this PostController */
/* @var $model PostItem */
/* @var $reply Reply */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/holder.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/community_post_view.js');

?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'reportModal')); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h4>Why are you reporting this thread discussion?</h4>
</div>
 
<div class="modal-body">
<div class="report-form">

     <?php echo $form->errorSummary($complaint); ?>

    <?php echo $form->textAreaRow($complaint, 'reason', array('class'=>'span12', 'rows'=>5, 'style' => 'resize: none;')); ?>
    <?php echo $form->hiddenField($complaint, 'post_item_id'); ?>
     <?php echo $form->hiddenField($complaint, 'reply_id'); ?>
    <?php echo $form->hiddenField($complaint, 'user_id'); ?>

</div><!-- form -->
</div>
 
<div class="modal-footer">

 <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Report')); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
'label' => 'Cancel',
'url' => '#',
'htmlOptions' => array('data-dismiss' => 'modal'),
)); ?>
</div>
<?php $this->endWidget(); ?> 
<?php $this->endWidget(); ?>

<?php
//foreach (Yii::app()->user->getFlashes() as $key => $message) {
//    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
//}

$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true, // display a larger alert block?
    'fade' => true, // use transitions?
    'closeText' => '×', // close link text - if set to false, no close link is displayed
    'alerts' => array(// configurations per alert type
        'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
         'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),// success, info, warning, error or danger
    ),
    'htmlOptions' => array('class' => 'forum-alert')
));
?>

<legend id="forum_topic_title">
    <?php echo CHtml::encode($thread['title']); ?> 
</legend>

<div class="media forum-post">
    <div class="media-object forum-id-box pull-left">
        <?php echo CHtml::hiddenField('user_id', $thread['user_id']) ?>
        <a href="#">
            <?php echo PostHelper::DrawUserAvatar($thread['profile_image']) ?>
            <h4><?php echo PostHelper::PrintPosterName($thread['username'], $thread['user_group_id']); ?></h4>  
        </a>  
        <p>Registered: <span><?php echo CHtml::encode($thread['register_date']) ?></span></p>
        <p>Posted: <span><?php echo CHtml::encode($thread['date_created']) ?></span></p>
    </div>

    <div class="media-body well">
        <div class="forum-text-area">
            <?php echo CHtml::decode($thread['description']) ?>
        </div>
        <div class="forum-post-bottom-bar">
            <strong><?php 
            
            if (!empty($thread['attachment']))
            {
            echo CHtml::decode(Yii::t('forum', 'forum.view.attachment') . ": "); echo CHtml::link($thread['attachment'], array('downloadAttachment', 'fileName' => $thread['attachment'], 'threadId' => $threadId));
            }
            
            ?></strong>
            <?php echo CHtml::link("<i class='icon-warning-sign'></i>" . Yii::t('forum', 'forum.view.report'), array('post/report', 'id' => $threadId), array('class' => 'forum-report-thread pull-right')) ?>
            <?php echo CHtml::hiddenField('forum_id', $threadId) ?>
            <?php echo CHtml::link(Yii::t('forum', 'forum.view.reply'), array('post/report', 'id' => $threadId), array('class' => 'forum-reply pull-right')) ?>
        </div>
    </div>
</div>

<hr class="forum-main-post-seperater"/>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => 'application.modules.community.views.front.post._post',
    'emptyText' => "<p class='forum-no-replies'>There are currently no replies</p>",
    'ajaxUpdate' => false
));
?>

<hr/>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'post-reply-form',
    'enableAjaxValidation' => false,
        ));
?>

<div id="forum-reply-indicator">
    <p class="lead"><i class="icon-hand-down"></i> Replying to <span id="forum-replying-to"></span>...</p>
    <?php //echo CHtml::button('Cancel', array('class' => 'forum-child-reply-cancel')); ?>
    <?php echo CHtml::link(Yii::t('forum', 'forum.view.cancel'), '#', array('class' => 'forum-child-reply-cancel')) ?>
</div>

<?php echo $form->hiddenField($reply, 'child_reply'); ?>

<?php echo $form->html5EditorRow($reply, 'message', array('height' => '150px', 'placeholder' => 'Type your reply message here...', 'labelOptions' => array('label' => false))); ?> 

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Reply',
    'htmlOptions' => array('id' => 'forum-btn-reply')));
?>

<?php $this->endWidget(); ?>
