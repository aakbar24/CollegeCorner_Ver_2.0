<?php

class WorkshopModule extends Module
{
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'workshop.models.forms.*',
				'workshop.models.views.*'
		));
	}
}
