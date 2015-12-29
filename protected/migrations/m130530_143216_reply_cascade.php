<?php

class m130530_143216_reply_cascade extends CDbMigration {

    public function up() {

        $db = $this->getDbConnection();
        $transaction = $db->beginTransaction();
        try {
        	$this->dropForeignKey('tbl_reply_ibfk_1', 'tbl_reply');
        	$this->addForeignKey('tbl_reply_ibfk_1', 'tbl_reply','post_item_id','tbl_thread','post_item_id','CASCADE','CASCADE');
        	
        	$this->dropForeignKey('tbl_reply_ibfk_3', 'tbl_reply');
        	$this->addForeignKey('tbl_reply_ibfk_3', 'tbl_reply','child_reply','tbl_reply','reply_id','CASCADE','CASCADE');
        	
            $transaction->commit();
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            $transaction->rollback();
            return false;
        }
    }

    public function down() {

        $db = $this->getDbConnection();
        $transaction = $db->beginTransaction();
        try {
        	$this->dropForeignKey('tbl_reply_ibfk_1', 'tbl_reply');
        	$this->addForeignKey('tbl_reply_ibfk_1', 'tbl_reply','post_item_id','tbl_thread','post_item_id','NO ACTION','CASCADE');
        	 
        	$this->dropForeignKey('tbl_reply_ibfk_3', 'tbl_reply');
        	$this->addForeignKey('tbl_reply_ibfk_3', 'tbl_reply','child_reply','tbl_reply','reply_id','NO ACTION','CASCADE');
        	 
            $transaction->commit();
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            $transaction->rollback();
            return false;
        }
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}