<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostDrawer
 *
 * @author Matthew
 */
class PostHelper {

    public static function PrintPosterName($name, $groupId) {
        
       $html = null; 

        switch ($groupId) {
            case Admin::USER_GROUP_ID:
            case SuperAdmin::USER_GROUP_ID:
                $html .= CHtml::decode($name . " <span class='admin'>(Admin)</span>");
                break;
            case CollegeAdmin::USER_GROUP_ID:
                $html .= CHtml::encode($name . " <span class='college_admin'>(College Admin)</span>");
                break;
            default:
                $html .= CHtml::encode($name);
                break;
        }

        return $html;
        
    }
    
    public static function PrintDisabledMessage() {
        
       $html = null; 

       $message = 'This message has been removed.';
       
       $html .= CHtml::tag('div', array('class' => 'alert alert-error'), $message);

        return $html;
        
    }

    public static function DrawUserAvatar($fileName = null)
    {
        $filePath = User::getProfileImageUploadUrl();
        Yii::log($filePath);

        $filePath .= !empty($fileName) ? $fileName : User::defaultImage;

        return CHtml::image($filePath, 'User Avatar', array('class' => 'avatar-holder'));

    }

}

?>
