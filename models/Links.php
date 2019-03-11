<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property int $vertex_1
 * @property int $vertex_2
 * @property int $weight
 * @property string $direction
 *
 * @property Vertices $vertex1
 * @property Vertices $vertex2
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vertex_1', 'vertex_2'], 'required'],
            [['vertex_1', 'vertex_2', 'weight'], 'default', 'value' => null],
            [['vertex_1', 'vertex_2', 'weight'], 'integer'],
            [['direction'], 'string'],
            [['vertex_1'], 'exist', 'skipOnError' => true, 'targetClass' => Vertices::className(), 'targetAttribute' => ['vertex_1' => 'id']],
            [['vertex_2'], 'exist', 'skipOnError' => true, 'targetClass' => Vertices::className(), 'targetAttribute' => ['vertex_2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vertex_1' => 'Vertex 1',
            'vertex_2' => 'Vertex 2',
            'weight' => 'Weight',
            'direction' => 'Direction',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVertex1()
    {
        return $this->hasOne(Vertices::className(), ['id' => 'vertex_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVertex2()
    {
        return $this->hasOne(Vertices::className(), ['id' => 'vertex_2']);
    }
}
