<?php

class ArticleForm extends CFormModel {

    public $postItem;
    public $article;
    public $isPublic = true;
    public $form = true;

    public function __construct($scenario='',$id=null) {

        if ($scenario == 'view' && $id != null) {
            $this->article = Article::model()->findByPk($id);
            if ($this->article != null) {
                $this->postItem = $this->article->postItem;
            } else {
                throw new CHttpException(400, 'Cannot find the article post.');
            }
        } else {
            $this->postItem = new PostItem();
            $this->article = new Article();

            $this->postItem->post_type_id = Article::POST_TYPE;
        }
    }

    public function rules() {
        return array(
            array('postItem', 'checkPostItem'),
            array('article', 'checkArticle'),
            array('form', 'safe'),
        );
    }

    public function checkPostItem($attribute, $params) {
        $ret = $this->postItem->validate();
        if (!$ret) {
            $this->addErrors($this->postItem->getErrors());
        }
    }

    public function checkArticle($attribute, $params) {
        $ret = $this->article->validate();
        if (!$ret) {
            $this->addErrors($this->article->getErrors());
        }
    }

    public function save() {
        //start a transaction
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if ($this->postItem->save()) {
                $this->article->save(true, null, $this->postItem);
            }

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public function attributeLabels() {
        
    }

    public function postedByCollegeAdmin() {
        return $this->postItem->user->user_group_id == CollegeAdmin::USER_GROUP_ID;
    }

}