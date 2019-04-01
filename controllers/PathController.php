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
    

    public $open_list=[];
    public $closed_list=[];
    public $unvisited_list = [];
    public $startVertex;
    public $goalVertex;
    public $currentVertex;
    public $graph;
    public $nextCurrent;

    public function actionFind(){
        $request = \Yii::$app->request;
        $start = $request->get('start');
        $destination = $request->get('end');
        $graphId = $request->get('graph');

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

        foreach($this->graph->vertices as $vertex){
            $this->unvisited_list[$vertex->id] = $vertex;
        }


        unset($this->unvisited_list[$this->startVertex->id]);
        $this->open_list[] = $this->startVertex->id;
        $this->startVertex->g = 0;
        $this->startVertex->f = $this->startVertex->g + $this->startVertex->h($this->goalVertex);

        $this->currentVertex = $this->startVertex;
       

        while (! empty($this->open_list)) {
            foreach($this->graph->vertices as $vertex){
                $weight = $this->graph->adjacencyMatrix[$this->currentVertex->id][$vertex->id];
                if ( $weight > -1 ) {

                    if (!in_array($vertex->id, $this->closed_list) && !in_array($vertex->id, $this->open_list)) {
                        unset($this->unvisited_list[$vertex->id]);
                        $this->open_list[] = $vertex->id;
                        $this->graph->vertices[$vertex->id]->parent = $this->currentVertex->id;
//                        $vertex->parent = $this->currentVertex->id;
                    }

                    $g = $this->currentVertex->g + $weight;
                    $f = $g + $vertex->h($this->goalVertex);

                    if ($vertex->f == 0 || $f < $vertex->f) {
                        $vertex->f = $f;
                        $vertex->g = $g;
                        $vertex->parent = $this->currentVertex;
                    }

                    $this->graph->vertices[$vertex->id] = $vertex;
                }
            }

            $this->closed_list[] = $this->currentVertex->id;
            $smallestf = 1000;
            foreach ($this->open_list as $openVertex) {
                $currentF = $this->graph->vertices[$openVertex]->f;
                if ( $currentF < $smallestf) {
                    $smallestf = $currentF;
                    $this->nextCurrent = $this->graph->vertices[$openVertex];
                }
            }
            $this->open_list = array_diff($this->open_list, [$this->nextCurrent->id]);
            $this->currentVertex = $this->nextCurrent;
        }

        $v = $this->graph->vertices[$this->goalVertex->id];
        $shortestPath = [];
        $links = [];

        while(!is_null($v)) {
            array_push($shortestPath, $v);

            if(!is_null($v->parent)){
                $link = $this->getLink($v->parent->id, $v->id);
                array_push( $links, $link);
            }

            $v = $v->parent;
        }

        $shortestPath = array_reverse($shortestPath);

        return [$shortestPath, $links, end($shortestPath)->g];

    }

    public function getLink($vertex_1, $vertex_2){
        return Links::findOne(['vertex_1'=> $vertex_1, 'vertex_2'=> $vertex_2]);
    }

//    public function getAdjacentVertices($vertex){
//
//    }

    // function g($start, $end){

    // }

    // function h($start, $end){

    // }

    // function f($start, $end){

    // }
    

}
