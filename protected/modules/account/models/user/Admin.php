<?php

class Admin extends User{

	

	const USER_GROUP_ID=3;

	

	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}

	

	public static function getDashboardItems(){
//echo "test";
		return array(

				'user'=>array('label'=>Yii::t('view', 'dashboard.user_lb'), 'url'=>'account/user/admin','icon'=>'user','description'=>'Manage Site Users'),

				'community'=>array('label'=>Yii::t('view', 'dashboard.community_lb'), 'url'=>'community/thread/admin','icon'=>'group','description'=>'Manage Student Communities'),

				'article'=>array('label'=>Yii::t('view', 'dashboard.article_lb'), 'url'=>'article/article/admin','icon'=>'edit-sign','description'=>'Manage Articles'),

				'workshop'=>array('label'=>Yii::t('view', 'dashboard.workshop_lb'), 'url'=>'workshop/workshop/admin','icon'=>'wrench','description'=>'Manage Workshops'),

				'event'=>array('label'=>Yii::t('view', 'dashboard.event_lb'), 'url'=>'event/event/admin','icon'=>'calendar','description'=>'Manage Events'),

				'certificate'=>array('label'=>Yii::t('view', 'dashboard.certificate_lb'), 'url'=>'certificate/certification/admin','icon'=>'list-alt','description'=>'Manage Certifications'),

				'slides'=>array('label'=>Yii::t('view', 'dashboard.home_page_slides_lb'), 'url'=>'slide/admin','icon'=>'picture','description'=>'Manage home page'),

                'migration'=>array('label'=>Yii::t('view', 'dashboard.migration_lb'), 'url'=>'migration/manage','icon'=>'truck','description'=>'Perform Database Migration'),

				

		);

	}

	

	public static function getAdminMenu(){

		return array(

				'item1'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.   One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.'),

				'item2'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item3'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item4'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item5'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item6'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item7'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item8'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item9'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

				'item10'=>array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index'),'icon'=>'star','description'=>'test'),

	

		);

	}

	

	public static function getMainNavItems(){

		return array(

				array('label'=>Yii::t('view', 'menu.dashboard_lb'), 'url'=>array('/account/auth/index')),

		);

	}

        

        public static function getCollege(){

            

        }

	

	public function search($excludeUserId=null)

	{

		// Warning: Please modify the following code to remove attributes that

		// should not be searched.

	

		$criteria=new CDbCriteria;

	

		$criteria->compare('user_id',$this->user_id);

		$criteria->compare('username',$this->username,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('first_name',$this->first_name,true);

		$criteria->compare('last_name',$this->last_name,true);

	

		$criteria->compare('profile_image',$this->profile_image,true);

		$criteria->compare('t.user_group_id',$this->user_group_id);

		$criteria->compare('is_notify',$this->is_notify);

		$criteria->compare('is_active',$this->is_active);

        $criteria->compare('is_verified',$this->is_verified);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		

		if($excludeUserId!=null){

			$criteria->addCondition('t.user_id <> :excludeUserId');

			$criteria->params[':excludeUserId']=$excludeUserId;

		}

		

		$criteria->with=array(

				'userGroup'=>array(

						'joinType'=>'INNER JOIN',

						'condition'=>'parent_group_id <> :adminGroupId AND userGroup.user_group_id <> :adminGroupId',

						'params'=>array(':adminGroupId'=>UserGroup::ADMIN_GROUP_ID)));



        $sort=array(

            'defaultOrder'=>'is_active DESC, is_verified DESC, t.user_group_id ASC, date_created DESC, date_created DESC, username ASC',

        );

		

		return $this->relatedSearch(

				$criteria,

            array('sort'=>$sort)

		);

	}

}

