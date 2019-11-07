<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m170505_085724_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'sequence' => $this->smallInteger()->notNull(),
            'title' => 'VARCHAR(2000) NOT NULL',
            'lecture' => $this->text()->notNull(),
            'lang' => $this->string(10),
            'course_id' => $this->integer()->notNull(),
            'status' => 'tinyint NOT NULL DEFAULT 10',
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('articles');
    }
}
