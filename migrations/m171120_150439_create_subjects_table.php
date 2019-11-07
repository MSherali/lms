<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subjects`.
 */
class m171120_150439_create_subjects_table extends Migration
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

        $this->createTable('subjects', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->unique(),
            'short_name' => $this->string(15)->unique(),
            'kafedra_id' => $this->integer(),
            'status' => 'tinyint NOT NULL DEFAULT 10',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subjects');
    }
}
