<?php

class CertificateModule extends Module
{
	protected function getModuleImport(){
		return CMap::mergeArray(parent::getModuleImport(), array(
				'certificate.models.forms.*',
				'certificate.models.views.*'
		));
	}
}
