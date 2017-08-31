<?php

use yii\db\Migration;

class m170829_212703_countries_creation extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(2)->unique(),
            'name' => $this->string(128)->notNull()->unique(),
            'population' => $this->integer()->notNull(),
            'flag_img' => $this->string()->notNull()
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170829_212703_countries_creation cannot be reverted.\n";

        return false;
    }
    */
}
