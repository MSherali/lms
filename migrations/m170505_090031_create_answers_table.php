<?php

use yii\db\Migration;

/**
 * Handles the creation of table `answers`.
 */
class m170505_090031_create_answers_table extends Migration
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
        $this->createTable('answers', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'answer' => 'VARCHAR(4000) NOT NULL',
            'is_correct' => 'tinyint NOT NULL DEFAULT 0',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('answers');
    }
}
