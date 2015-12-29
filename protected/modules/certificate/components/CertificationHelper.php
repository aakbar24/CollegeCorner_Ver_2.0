<?php
class CertificationHelper {
	public static function getCertficationCatLabel($cert){
		if($cert instanceof Certification){
			return CHtml::tag('span',array('class'=>'label label-info'),$cert->certification_cat_name,true);
		}
	}
}