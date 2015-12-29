
<div class="media hero-unit">
        <?php
        $image = CHtml::image(WorkshopFacilitator::generateImagePath($data['facil_image']), $data['facil_first_name'] . " " . $data['facil_last_name'], array('class'=>'media-object pull-left', 'data-src'=>'holder.js/128x128/social/text: 128 x 128 Workshop'));
       echo $image;
        ?>
    <div class="media-body">
        <div class="media posting-text">
            <p>
            <?php

            echo Formatter::truncate($data['description'], Yii::app()->params['posting_max_text_length'], " ") ;

            ?>
            </p>
        </div>
    </div>

</div>
