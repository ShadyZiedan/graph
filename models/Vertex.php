<?php

namespace app\models;

class Vertex {
    public $id;
    public $x;
    public $y;
    public $g;
    public $f;
    public $parent;

    public function __construct($id, $x, $y){
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
    }

    public function h($destination){

        return sqrt(pow($this->x - $destination->x, 2) + pow($this->y - $destination->y, 2)); // Euclidean distance
    }

    public static function compare($vertex1, $vertex2){
        return $vertex1 === $vertex2;
    }
    
}