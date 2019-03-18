<?php

namespace app\models;

class Graph{
    public $totalVertices;
    public $vertices = [];
    public $adjacencyMatrix = [];

//    public function __construct()
//    {
//        $this->vertices = new \SplObjectStorage();
//    }

    public function addVertex($vertex){
        $this->vertices[$vertex->id] = new Vertex($vertex->id, $vertex->x, $vertex->y);
    }

    public function initializeAdjMat(){
        foreach ($this->vertices as $vertex1Id => $vertex1){
            foreach ($this->vertices as $vertex2Id => $vertex2){
                $this->adjacencyMatrix[$vertex1Id][$vertex2Id] = 0;
            }
        }

    }
    public function addEdge($link){
        $vertex1 = $link->vertex_1;
        $vertex2 = $link->vertex_2;
        $direction = $link->direction;
        
        $this->adjacencyMatrix[$vertex1][$vertex2] = $link->weight;

        if($direction == 'bi'){
            $this->adjacencyMatrix[$vertex2][$vertex1] = $link->weight;
        }
    }
}