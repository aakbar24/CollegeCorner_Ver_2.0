<?php
/* @var $this PostController */
?>

<div class="media forum-post">
    <div class="media-object forum-id-box pull-left">
        <?php echo CHtml::hiddenField('user_id', $data['user_id']) ?>
        <a href="#">
            <?php echo PostHelper::DrawUserAvatar($data['profile_image']) ?>
            <h4><?php echo PostHelper::PrintPosterName($data['username'], $data['user_group_id']); ?></h4>  
        </a>  
        <p>Registered: <span><?php echo CHtml::encode($data['register_date']); ?></span></p>
        <p>Posted: <span><?php echo CHtml::encode($data['date_created']); ?></span></p>
    </div>

    <div class="media-body well">
        <div class="forum-text-area">

            <?php if ($data['child_reply']): ?>
                <?php
                $childReply = Reply::model()->getChildReplyPosting($data['child_reply']);
                $this->widget('bootstrap.widgets.TbBox', array(
                    'title' => "In reply to <a href='#'>" . PostHelper::PrintPosterName($childReply['username'], $childReply['user_group_id'])  . "</a>",
                    'headerIcon' => 'icon-arrow-left',
                    'content' => $childReply['is_active'] ? CHtml::decode($childReply['message']) :  PostHelper::PrintDisabledMessage()// $this->renderPartial('_view')
                ));
                ?>
            <?php endif; ?>

            <?php
            echo $data['is_active'] ? CHtml::decode($data['message']) : PostHelper::PrintDisabledMessage();
            ?>
        </div>
        
        <?php if ($data['is_active']): ?>
           
        <div class="forum-post-bottom-bar">
<?php echo CHtml::link("<i class='icon-warning-sign'></i>" . Yii::t('forum', 'forum.view.report'), array('post/report', 'id' => $data['id']), array('class' => 'forum-report pull-right')) ?>
            <?php echo CHtml::hiddenField('reply_id', $data['id']) ?>
<?php echo CHtml::link(Yii::t('forum', 'forum.view.reply'), '#', array('class' => 'forum-reply pull-right')) ?>
        </div>
        
        <?php endif; ?>
        
    </div>
</div>