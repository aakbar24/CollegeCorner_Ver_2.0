<?php
/* @var $this SiteController */
$this->layout = '//layouts/resource';
$this->pageTitle = Yii::app()->name . ' - ' . $data['title'];
?>

<?php

//$this->renderPartial("//layouts/_post_items_header",array('type'=>$type));

?>

<div>
    <div class="row-fluid">
    <div id="read_posting" class="span12">



        <?php echo CHtml::tag("h2", array('id'=>'title'), $data['title']); ?>
        <hr/>
        <?php echo CHtml::tag("p", array('id'=>'subheading'),  "by " .   $data['username'] . " &nbsp | &nbsp " . $data['date_created']); ?>
        <hr/>

        <?php

        if (!empty($data['article_image']))
        {
            $illustration = CHtml::image(Article::generateImagePath($data['article_image'], $data['id']), $data['title'], array('id'=>'illustration', 'class'=>'img-polaroid'));
            echo CHtml::tag("div", array('class'=>'illustration-holder'), $illustration);
            echo CHtml::tag("hr");
        }

        ?>

        <?php

        $content = CHtml::tag("p", array('id'=>'content'), $data['description']);
        echo CHtml::tag("div", array('class'=>'content-holder'),$content);

        ?>

        <?php if (!empty($data['source'])): ?>

        <blockquote>
            <small>
                <?php
                $link = Chtml::link($data['source'], $data['source'], array('id'=>'source-link'));
                echo CHtml::tag('cite', array('title'=>$data['title'], 'target'=>'_blank'), "Source: " . $link);
                ?>
            </small>
        </blockquote>

        <?php endif; ?>

    </div>

    </div>
</div>

