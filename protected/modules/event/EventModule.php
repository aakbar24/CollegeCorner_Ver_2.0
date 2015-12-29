<?php

class EventModule extends Module
{
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'event.models.forms.*',
				'event.models.views.*'
		));
	}
}
