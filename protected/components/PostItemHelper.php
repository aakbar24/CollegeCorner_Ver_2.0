<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Matthew
 * Date: 6/24/13
 * Time: 8:07 PM
 * To change this template use File | Settings | File Templates.
 */

class PostItemHelper {

    public static function drawPostItemLabel($post_type_id, $text = null)
    {

        $class = "label ";

        switch ($post_type_id)
        {
            case Article::POST_TYPE:
            {
                $class .= "label-info"; //blue
                $content = Yii::t("model", 'article.article');
                break;
            }
            case Article::POST_TYPE_NEWS:
            {
                $class .= "label-warning"; //yellow
                $content = Yii::t("model", 'news.news');
                break;
            }
            case Event::POST_TYPE:
            {
                $class .= "label-success"; //green
                $content = Yii::t("model", 'event.event');
                break;
            }
            case Workshop::POST_TYPE:
            {
                $class .= "label-important"; //red
                $content = Yii::t("model", 'workshop.workshop');
                break;
            }
                default:
                return null;
        }

        if ($text != null)
            $content = $text;

        return CHtml::tag("span", array('class'=> $class), $content);
    }
    
    public static function registerExcerptScripts($formId){
    	Yii::app()->clientScript->registerScript('#'.$formId.'#Excerpt',
    			<<<EOD
		jQuery(document).on('submit','#{$formId}', function(e){
			var excerpt='';
			$('p',$('<div>'+$('#PostItem_description').val()+'</div>')).each(function(idx,value){excerpt+=$(value).text()+" ";});
			if(excerpt.length>500) excerpt=excerpt.substring(0,450);
			$('#PostItem_excerpt').val(excerpt);
		
		});
    	
EOD
    			,
    			CClientScript::POS_READY);
    }

}