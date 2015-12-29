<?php

class ResumeModule extends Module
{
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'resume.models.forms.*',
				'resume.models.views.*'
				));
	}
}
