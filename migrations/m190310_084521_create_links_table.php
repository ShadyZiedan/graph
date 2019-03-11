<?php

use yii\db\Migration;

/**
 * Handles the creation of table `links`.
 */
class m190310_084521_create_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE directionEnum AS ENUM ('uni', 'bi')");
        $this->createTable('links', [
            'id' => $this->primaryKey(),
            'vertex_1' => $this->integer()->notNull(),
            'vertex_2' =>$this->integer()->notNull(),
            'weight' => $this->integer()->notNull()->defaultValue(0),
            'direction' => "directionEnum default 'uni'",
        ]);
        
        $this->createIndex(
            'idx-links-vertex_1',
            'links',
            'vertex_1'
        );

        $this->createIndex(
            'idx-links-vertex_2',
            'links',
            'vertex_2'
        );

        $this->addForeignKey(
            'fk-links-vertex_1',
            'links',
            'vertex_1',
            'vertices',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-links-vertex_2',
            'links',
            'vertex_2',
            'vertices',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('links');
    }
}
