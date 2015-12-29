
<!--<div class="media hero-unit"> -->
        <?php
        $image = CHtml::image(Article::generateImagePath($data['article_image'], $data['id']), "Article", array('class'=>'media-object', 'data-src'=>'holder.js/128x128/social/text: 128 x 128 Article'));
        echo CHtml::link($image,  array('readPosting', 'id'=>$data['id']), array('class'=>'pull-left'));
        ?>
   <!-- <div class="media-body"> -->
        <!--<div class="news_cont"> -->
            <?php

            echo $data['description'];
            echo CHtml::link("[Full Post...]",  array('readPosting', 'id'=>$data['id']), array('class' => 'more_hyperlink'));

            ?>
        <!--</div>-->
   <!-- </div> -->


<!--</div>-->
