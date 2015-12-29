<?php

class AccountModule extends Module
{
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'account.models.user.*',
				'account.models.forms.*',
				'account.models.views.*'
		));
	}
}
