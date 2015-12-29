
<h1>Manage Complaints <?php echo CHtml::link("?", "#", array('id' => 'show_complaint_help')); ?></h1>

    <dl id="manage_complaint_help" class="dl-horizontal">
    <dt><i class="icon-eye-open"></i></dt>
    <dd>View the forum or message post.</dd>
    
    <dt><i class="icon-trash"></i></dt>
    <dd>Delete the thread.</dd>
    
    <dt><i class="icon-thumbs-up"></i></dt>
    <dd>Mark the thread or message as 'safe'. Will be removed from complaints.</dd>
    
    <dt><i class="icon-eye-close"></i></dt>
    <dd>Disable the thread or message. Will no longer be seen by users. Disabling the original poster's message will disable the entire thread.</dd>
    </dl>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'filter' => $model,
    'type' => 'striped bordered',
    'dataProvider' => $model->search(true),
    'template' => "{items}",
    'emptyText' => 'No posts have been reported.',
    'columns' => array_merge(array(
        array(
            'class' => 'bootstrap.widgets.TbRelationalColumn',
            'header' => 'Thread ID',
            'name' => 'post_item_id',
            'url' => $this->createUrl('complaint/relational'),
            'value' => '$data->post_item_id',
            'filter' => false,
        ), array('header' => 'Title', 'name' => 'postItem.title'),
        array('header' => 'Poster', 'name' => 'postItem.user.username'),
        array(
            'htmlOptions' => array('nowrap' => 'nowrap'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete} | {safe} {disable}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("/post/readTopic", array("id"=>$data->post_item_id))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/thread/delete", array("id"=>$data->post_item_id))',
            'deleteConfirmation'=>'Are you sure you want to delete this thread? Doing so will remove all of its associated complaints.',
            'buttons' => array
                (
                'safe' => array
                    (
                    'label' => 'Safe',
                    'icon' => 'thumbs-up',
                    'url' => 'Yii::app()->createUrl("complaint/threadSafe", array("thread_id"=>$data->post_item_id))',
                ),
                'disable' => array
                    (
                    'label' => 'Disable',
                    'icon' => 'eye-close',
                    'url' => 'Yii::app()->createUrl("thread/toggle", array("id"=>$data->post_item_id))',
                )
            )
        )
    )),
));
?>

<script>
    
    $(document).ready(function (){
       
       $("#show_complaint_help").click(function(){
          
          $("#manage_complaint_help").toggle("slow");
          
       });
       
    });
    
    </script>
