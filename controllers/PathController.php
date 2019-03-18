<?php

namespace app\controllers;

use app\models\Graph;
use app\models\Graphs;
use app\models\Links;
use app\models\Vertex;
use app\models\Vertices;
use yii\rest\Controller;


/**
 * SearchController implements the CRUD actions for Search model.
 */
class PathController extends Controller
{
    
    // public $modelClass = 'app\models\Graphs';

    public $open_list=[];
    public $closed_list=[];
    public $unvisited_list = [];
    public $startVertex;
    public $goalVertex;
    public $currentVertex;
    public $graph;

    public function actionFind(){
        $start = $_GET['start'];
        $destination = $_GET['end'];
        $graphId = $_GET['graph'];

        $start = Vertices::findOne($start);
        $destination = Vertices::findOne($destination);
        $this->startVertex = new Vertex($start->id, $start->x, $start->y);
        $this->goalVertex = new Vertex($destination->id, $destination->x, $destination->y);
        $this->graph = new Graph();
        $modelGraph = Graphs::findOne($graphId);
        $this->graph->id = $modelGraph->id;
        $vertices = $modelGraph->getVertices()->all();

        $verticesIds = [];
        foreach ($vertices as $vertex){
            array_push($verticesIds, $vertex->id);
            $graphVertex = new Vertex($vertex->id, $vertex->x, $vertex->y);
//            array_push($this->graph->vertices, $graphVertex );
            $this->graph->vertices[$graphVertex->id] = $graphVertex;
        }

        $this->graph->initializeAdjMat();

        $links = Links::find()
            ->where(['vertex_1'=> $verticesIds])->all();

        foreach ($links as $link){
            $this->graph->addEdge($link);
        }
        
//        $this->unvisited_list = new \SplObjectStorage();
        foreach($this->graph->vertices as $vertex){
            $this->unvisited_list[$vertex->id] = $vertex;
        }


//        $this->unvisited_list = array_diff($this->unvisited_list, [$start]);
//        $this->unvisited_list->detach($start);
        unset($this->unvisited_list[$this->startVertex->id]);
        $this->startVertex->g = 0;
        $this->startVertex->f = $this->startVertex->g + $this->startVertex->h($this->goalVertex);

        $this->currentVertex = $this->startVertex;
       
        while (! Vertex::compare($this->currentVertex, $this->goalVertex)) {
            foreach($this->graph->vertices as $vertex){
                if ($this->graph->adjacencyMatrix[$this->currentVertex->id][$vertex->id] > 0) {

                    if (!in_array($vertex->id, $this->closed_list) && !in_array($vertex->id, $this->open_list)) {
                        unset($this->unvisited_list[$vertex->id]);
                        $this->open_list[] = $vertex->id;
                        $this->graph->vertices[$vertex->id]->parent = $this->currentVertex->id;
                    }

                    $g = $this->currentVertex->g + $this->graph->adjacencyMatrix[$this->currentVertex->id][$vertex->id];
                    $f = $g + $vertex->h($this->goalVertex);

                    if ($vertex->f == 0 || $f < $vertex->f) {
                        $vertex->f = $f;
                        $vertex->g = $g;
                        $vertex->parent = $this->currentVertex;
                    }


                }
            }

            $this->closed_list[] = $this->currentVertex->id;
            $smallestf = 1000;
            $nextCurrent=0;
            foreach ($this->open_list as $openVertex) {
                $currentF = $this->graph->vertices[$openVertex]->f;
                if ( $currentF < $smallestf) {
                    $smallestf = $currentF;
                    $nextCurrent = $openVertex;
                }
            }
            $this->open_list = array_diff($this->open_list, [$nextCurrent]);
            $this->currentVertex = $nextCurrent;
        }

        $v = $this->graph->vertices[$this->goalVertex->id];
        $shortestPath = [];
        do {
            array_push($shortestPath, $v);
            $v = $v->parent;
        } while ($v->parent != null);

        $shortestPath = array_reverse($shortestPath);

        return [$shortestPath, $this->currentVertex->g];
        // while(!empty($open_list)){
            
        // }
    }

    public function getAdjacentVertices($vertex){
        
    }

    // function g($start, $end){

    // }

    // function h($start, $end){

    // }

    // function f($start, $end){

    // }
    

}
