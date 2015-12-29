

<h1>Manage Community Forums</h1>
<h1>(Reported Threads)</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php 

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

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'thread-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        array('name' => 'post_item_id', 'filter' => false, 'type' => 'html', 'value' => 'CHtml::link($data->post_item_id, array("/post/readTopic", "id"=>$data->post_item_id))', 'header' => 'ID', 'htmlOptions' => array('style' => 'width: 50px;')),
        array('header' => 'Title', 'name' => 'post_item_id', 'type' => 'html', 'value' => 'CHtml::link($data->postItem->title, array("/post/readTopic", "id"=>$data->post_item_id))'),
        'program_code',
        array('name' => 'college_id', 'value' => '$data->college->college_name', 'filter' => CHtml::listData(College::getCollegeFilter(Yii::app()->user->user_group_id), 'college_id', 'college_name')),
        array('name' => 'program_id', 'value' => '$data->program->program_name', 'filter' => CHtml::listData(Program::getProgramFilter(), 'program_id', 'program_name')),
        array('name' => 'semester_id', 'filter' => CHtml::dropDownList('Thread[semester_id]', $model->semester_id, array('1' => 1, 2, 3, 4, 5, 6), array('empty' => '(Select)')), 'htmlOptions' => array('style' => 'width: 105px;')),
        array('name' => 'attachment', 'filter' => false, 'type'=>'html', 'value' => '!empty($data->attachment) ? CHtml::link("Yes", array("post/downloadAttachment", "fileName"=>$data->attachment, "threadId" => $data->post_item_id)) : "No"'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("/post/readTopic", array("id"=>$data->post_item_id))'
            
        ),
    ),
));
?>

<!--'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'-->
