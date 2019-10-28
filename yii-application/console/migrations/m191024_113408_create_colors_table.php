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
            'color' => $this->string(40)->notNull(),
        ]);

        $this->batchInsert(
            'colors',
            ['color'],
            [
                ['green'],
                ['orange'],
                ['red'],
                ['black'],
            ]
        );

        $this->createIndex(
            'colorId',
            'apples',
            'colorId'
        );

        $this->addForeignKey(
            'colorId',
            'apples',
            'colorId',
            'colors',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'colorId',
            'apples'
        );

        $this->dropIndex(
            'colorId',
            'apples'
        );

        $this->dropTable('{{%colors}}');
    }
}
