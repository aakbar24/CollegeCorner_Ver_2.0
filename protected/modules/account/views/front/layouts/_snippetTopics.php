<?php

?>

<div class="row-fluid">

    <div class="span-12">

        <div class="snippet-header">
            <h1><?php echo Yii::t('view', 'topic.today'); ?></h1>
        </div>

        <?php

        $this->widget('bootstrap.widgets.TbGridView', array(
            'dataProvider' => Thread::getTodaysThreadsSnippet(College::getUserCollege()->college_id),
            'columns' => array(
                array(
                    'header'=>'Title',
                    'name' => 'title',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data["title"], array("/community/post/readTopic", "id" => $data["id"]));'),
                array(
                    'header'=>'Forum',
                    'name' => 'program_name',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data["program_name"], array("/community/forum/programView", "programId" => $data["program_id"]));'
                ),
                array(
                    'header'=>'Semester',
                    'name' => 'semester_name',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data["semester_name"], array("/community/forum/viewTopics", "programId" => $data["program_id"], "semesterId" => $data["semester_id"]));'),
                array(
                    'header'=>'Program Code',
                    'name' => 'program_code',),
                array(
                    'header'=>'Date Posted',
                    'name' => 'date_created',
                    'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["date_created"]))'),
            ),
            'template' => "{items}",
            'emptyText' => "There are currently no Topics today",
            'type' => 'bordered',
            'htmlOptions' => array('class' => 'snippetTopicGrid')
        ));

        $btn = $this->widget('bootstrap.widgets.TbButton',array(
            'label' => Yii::t('view', 'topic.more'),
            'type' => 'primary',
            'size' => 'large',
            'url' => array('/community/forum/todaysTopics'),
            'icon' => 'comment'
        ), true);

        echo CHtml::tag('div', array('class'=>'snippet-more-area'), $btn);

        ?>

    </div>

</div>