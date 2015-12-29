<?php

class m130523_222954_add_search_table extends CDbMigration {

    public function up() {


        $db = $this->getDbConnection();
        $transaction = $db->beginTransaction();
        try {
            $this->getDbConnection()->createCommand('CREATE TABLE IF NOT EXISTS `tbl_post_item_search` (
  `post_item_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;')->execute();
            
            $this->getDbConnection()->createCommand('ALTER TABLE `tbl_post_item_search` ADD FULLTEXT (title, description)')->execute();
            $this->getDbConnection()->createCommand('CREATE TRIGGER `tbl_post_item_mirror_search` AFTER INSERT ON `tbl_post_item`
 FOR EACH ROW insert into tbl_post_item_search select post_item_id, title, description from tbl_post_item 
WHERE post_item_id = NEW.post_item_id ')->execute();
            
            $this->getDbConnection()->createCommand('INSERT INTO tbl_post_item_search( post_item_id, title, description )
SELECT post_item_id, title, description
FROM tbl_post_item')->execute();
            
            
            
            
            
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
            $this->getDbConnection()->createCommand('DROP TRIGGER IF EXISTS `tbl_post_item_mirror_search`')->execute();
            
             $this->getDbConnection()->createCommand('DROP TABLE IF EXISTS tbl_post_item_search')->execute();
   
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