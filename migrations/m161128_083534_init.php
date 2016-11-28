<?php

use mycone\users\migrations\Migration;
use mycone\users\models;

class m161128_083534_init extends Migration
{
    public function up()
    {
        //depts table
        $this->createTable(models\Depts::tableName(), [
            'id' => $this->bigPrimaryKey(),
            'root' => $this->integer(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'lvl' => $this->smallInteger(5)->notNull(),
            'name' => $this->string(60)->notNull(),
            'icon' => $this->string(255),
            'icon_type' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'selected' => $this->boolean()->notNull()->defaultValue(false),
            'disabled' => $this->boolean()->notNull()->defaultValue(false),
            'readonly' => $this->boolean()->notNull()->defaultValue(false),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'collapsed' => $this->boolean()->notNull()->defaultValue(false),
            'movable_u' => $this->boolean()->notNull()->defaultValue(true),
            'movable_d' => $this->boolean()->notNull()->defaultValue(true),
            'movable_l' => $this->boolean()->notNull()->defaultValue(true),
            'movable_r' => $this->boolean()->notNull()->defaultValue(true),
            'removable' => $this->boolean()->notNull()->defaultValue(true),
            'removable_all' => $this->boolean()->notNull()->defaultValue(false)
        ], $this->tableOptions);
        $this->createIndex('tree_NK1', models\Depts::tableName(), 'root');
        $this->createIndex('tree_NK2', models\Depts::tableName(), 'lft');
        $this->createIndex('tree_NK3', models\Depts::tableName(), 'rgt');
        $this->createIndex('tree_NK4', models\Depts::tableName(), 'lvl');
        $this->createIndex('tree_NK5', models\Depts::tableName(), 'active');
        
        //employees tables
        $this->createTable(models\Employees::tableName(), [
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string(30)->notNull()->unique(),
            'password_hash' => $this->char(64)->notNull(),
            'auth_key' => $this->char(32)->notNull()->unique(),
            'depts_id' => $this->integer(10)->unsigned()->notNull(),
            'fullname' => $this->string(15)->defaultValue(null),
            'telphone' => $this->string(50)->defaultValue(null),
            'email' => $this->string(50)->defaultValue(null),
            'idcard' => $this->string(18)->defaultValue(18),
            'jobs' => $this->string(50)->defaultValue(null),
            'last_at' => $this->bigInteger(20)->defaultValue(null),
            'last_ip' => $this->string(15)->defaultValue(null),
            'status' => "TINYINT(3) NOT NULL DEFAULT '1' ",
            'avatar' => $this->string(250)->defaultValue(null),
            'remark' => $this->text(),
            'created_at' => $this->bigInteger(20)->notNull(),
        ],$this->tableOptions);
        $this->createIndex('status', models\Employees::tableName(), 'status');
        
    }

    public function down()
    {
        echo "m161128_083534_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
