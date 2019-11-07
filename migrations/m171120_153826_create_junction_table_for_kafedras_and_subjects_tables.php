<?php

use yii\db\Migration;

/**
 * Handles the creation of table `kafedras_subjects`.
 * Has foreign keys to the tables:
 *
 * - `kafedras`
 * - `subjects`
 */
class m171120_153826_create_junction_table_for_kafedras_and_subjects_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('kafedras_subjects', [
            'kafedras_id' => $this->integer(),
            'subjects_id' => $this->integer(),
            'PRIMARY KEY(kafedras_id, subjects_id)',
        ]);

        // creates index for column `kafedras_id`
        $this->createIndex(
            'idx-kafedras_subjects-kafedras_id',
            'kafedras_subjects',
            'kafedras_id'
        );

        // add foreign key for table `kafedras`
        $this->addForeignKey(
            'fk-kafedras_subjects-kafedras_id',
            'kafedras_subjects',
            'kafedras_id',
            'kafedras',
            'id',
            'CASCADE'
        );

        // creates index for column `subjects_id`
        $this->createIndex(
            'idx-kafedras_subjects-subjects_id',
            'kafedras_subjects',
            'subjects_id'
        );

        // add foreign key for table `subjects`
        $this->addForeignKey(
            'fk-kafedras_subjects-subjects_id',
            'kafedras_subjects',
            'subjects_id',
            'subjects',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `kafedras`
        $this->dropForeignKey(
            'fk-kafedras_subjects-kafedras_id',
            'kafedras_subjects'
        );

        // drops index for column `kafedras_id`
        $this->dropIndex(
            'idx-kafedras_subjects-kafedras_id',
            'kafedras_subjects'
        );

        // drops foreign key for table `subjects`
        $this->dropForeignKey(
            'fk-kafedras_subjects-subjects_id',
            'kafedras_subjects'
        );

        // drops index for column `subjects_id`
        $this->dropIndex(
            'idx-kafedras_subjects-subjects_id',
            'kafedras_subjects'
        );

        $this->dropTable('kafedras_subjects');
    }
}
