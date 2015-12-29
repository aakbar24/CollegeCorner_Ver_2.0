<?php
/* @var SiteController $this*/
?>
<div id="article_listings">
    <div class="date_time">
        <?php echo $data['date_created'] ?>   
    </div>
    <div class="news_head">
        <?php
        $this->widget('bootstrap.widgets.TbBox', array(
            //'title' => $data['title'] . PostItemHelper::drawPostItemLabel($data['post_type_id']),
			//'content' => $this->renderPartial('//layouts/_article_content', array('data' => $data), true)
			'title' => $data['title'] . PostItemHelper::drawPostItemLabel($data['post_type_id']),
            'content' => $this->renderPartial('//layouts/_article_content', array('data' => $data), true)
        ));
        ?>
    </div>
</div>
