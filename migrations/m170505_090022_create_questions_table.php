<?php

use yii\db\Migration;

/**
 * Handles the creation of table `questions`.
 */
class m170505_090022_create_questions_table extends Migration
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

        $this->createTable('questions', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'question' => $this->text()->notNull(),
            'difficulty' => 'tinyint NOT NULL DEFAULT 1',
            'multianswer' => 'tinyint NOT NULL DEFAULT 0',
            'lang' => $this->string(2)->notNull()->defaultValue('uz'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('questions');
    }
}
