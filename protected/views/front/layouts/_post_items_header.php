<?php
if (!isset($type))
    $type = null
?>

<div class="container">
    <div id="post_items_header" class="row-fluid">

        <?php
        /*        $this->widget('bootstrap.widgets.TbTabs', array(
                    'type' => 'tabs', // 'tabs' or 'pills'
                    'tabs' => array(
                        array('label' => Yii::t('view', 'articles.articles'), 'active' => true),
                        array('label' => Yii::t('view', 'events.events'), 'content' => 'Profile Content'),
                        array('label' => Yii::t('view', 'news.news'), 'content' => 'Messages Content', 'itemOptions'=>array('class'=>'disabled', 'href'=>'#')),
                    ),
                    'htmlOptions' => array('id' => 'learn_navbar')
                ));
                */?>

        <ul id="learn_navbar" class="nav nav-tabs">
            <?php
            $link = CHtml::link(Yii::t('view', 'articles.articles'), array('articles'));
            echo CHtml::tag("li", $type == Article::POST_TYPE ? array('class' => 'active') : array(), $link);

           /* $link = CHtml::link(Yii::t('view', 'events.events'), array('events'));
            echo CHtml::tag("li", $type == Event::POST_TYPE ? array('class' => 'active') :array(), $link);*/

            $link = CHtml::link(Yii::t('view', 'news.news'), array('news'));
            echo CHtml::tag("li", $type == Article::POST_TYPE_NEWS ? array('class' => 'active') : array(), $link);
            ?>
            <!--            <li class="active">
                            <a href="#">Articles</a>
                        </li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">News</a></li>-->
        </ul>

        <?php if (isset($this->viewBreadcrumb)): ?>
            <?php
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                'links' => $this->viewBreadcrumb,
            ));
            ?>
            <!-- breadcrumbs -->
        <?php endif ?>

    </div>
</div>