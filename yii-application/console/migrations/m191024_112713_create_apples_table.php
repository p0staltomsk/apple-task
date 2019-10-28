<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m191024_112713_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id'            => $this->primaryKey(),
            'colorId'       => $this->integer(11)->notNull(),
            'statusId'      => $this->integer(11)->notNull(),
            'dateCreated'   => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'dateFalls'     => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'size'          => $this->float(3)->notNull()->defaultValue(1.0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apples}}');
    }
}
