<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%colors}}`.
 */
class m191024_113408_create_colors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%colors}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%colors}}');
    }
}
