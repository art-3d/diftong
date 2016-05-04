<?php

use yii\db\Migration;

class m160502_192342_create_user_table extends Migration
{
    public function up()
    {
    	  $tableOptions = null;
    	  if ($this->db->driverName === 'mysql') {
    	  	$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    	  }
    	  
        $this->createTable('user_table', [
            'id' 					=> $this->primaryKey(),
            'username'			=> $this->string(255)->notNull()->unique(),
            'email'				=> $this->string()->notNull()->unique(),
            'password_hash'	=> $this->string(60),
            'created_at'		=> $this->timestamp(),
            'updated_at'		=> $this->timestamp(),
            'auth_key'			=> $this->string(32),
        ]);
    }

    public function down()
    {
        $this->dropTable('user_table');
    }
}
