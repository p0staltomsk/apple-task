<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m191024_113810_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string(40)->notNull(),
        ]);

        $this->batchInsert(
            'status',
            ['status'],
            [
                ['onTree'],
                ['falledToGround'],
                ['spoiledRotten']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
