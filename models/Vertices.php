<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vertices".
 *
 * @property int $id
 * @property int $graph_id
 * @property double $x
 * @property double $y
 *
 * @property Links[] $links
 * @property Links[] $links0
 * @property Graphs $graph
 */
class Vertices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vertices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['graph_id', 'x', 'y'], 'required'],
            [['graph_id'], 'default', 'value' => null],
            [['graph_id'], 'integer'],
            [['x', 'y'], 'number'],
            [['graph_id'], 'exist', 'skipOnError' => true, 'targetClass' => Graphs::className(), 'targetAttribute' => ['graph_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'graph_id' => 'Graph ID',
            'x' => 'X',
            'y' => 'Y',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Links::className(), ['vertex_1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks0()
    {
        return $this->hasMany(Links::className(), ['vertex_2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGraph()
    {
        return $this->hasOne(Graphs::className(), ['id' => 'graph_id']);
    }
}
