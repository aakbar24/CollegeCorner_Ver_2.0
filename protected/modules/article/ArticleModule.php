<?php

class ArticleModule extends Module
{
     public function init() {
        parent::init();
        
     }
    
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'article.models.forms.*',
		));
        }
}
