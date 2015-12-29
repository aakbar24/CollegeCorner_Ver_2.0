<?php

class CommunityModule extends Module
{
    public function init() {
        parent::init();
        
        Yii::app()->params['forum_max_crumb_length'] = 40;
        Yii::app()->params['forum_max_latest_reply_length'] = 30;
         Yii::app()->params['forum_pageSize'] = 20;
    }
    
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'community.models.*',
                                'community.models.forms.*'
				));
	}
}
