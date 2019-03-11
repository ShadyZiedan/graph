<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vertices}}`.
 */
class m190310_084134_create_vertices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vertices', [
            'id' => $this->primaryKey(),
            'graph_id' => $this->integer()->notNull(),
            'x' => $this->float()->notNull(),
            'y' => $this->float()->notNull(),
        ]);

        $this->createIndex(
            'idx-vertices-graph_id',
            'vertices',
            'graph_id'
        );

        $this->addForeignKey(
            'fk-vertices-graph_id',
            'vertices',
            'graph_id',
            'graphs',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vertices');
    }
}
