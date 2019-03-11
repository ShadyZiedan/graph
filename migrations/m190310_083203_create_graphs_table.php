<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%graphs}}`.
 */
class m190310_083203_create_graphs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('graphs', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('graphs');
    }
}
