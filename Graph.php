<?php

class Graph
{
  private array $nodes = [];
  private array $edges = [];

  public function createFromIncidenceMatrix(IOData $source) : void
  {
    $data = $source->getData();
    $count_node = count($data);
    $count_edge = count($data[0]);

    for ($i = 0; $i < $count_edge; $i++) {
      list($from, $to, $cost, $reverse) = [null, null, null, false];
      for ($j = 0; $j < $count_node; $j++) {
        if ($data[$j][$i] > 0) {
          $cost = $data[$j][$i];
          // случай когда связь взаимная
          if (is_null($from)){
            $from = $j;
          } else {
            $to = $j;
            $reverse = true;
          }
        } elseif ($data[$j][$i] < 0) {
          $to = $j;
        }

        if (!is_null($from) && !is_null($to)) {
          $master = $this->existNode($from);
          $slave = $this->existNode($to);
          $edge = new Edge($master, $slave, $cost);
          $this->edges [] = $edge;
          $master->addEdge(count($this->edges)-1);
          if ($reverse) {
            $edge = new Edge($slave, $master, $cost);
            $this->edges [] = $edge;
            $slave->addEdge(count($this->edges)-1);
          }
          break;
        }
      }

    }
  }

  private function existNode(int $id) : Node
  {
    foreach ($this->nodes as $node) {
      if ($node->getId() === $id) {
        return $node;
      }
    }
    $node = new Node($id);
    $this->nodes [] = $node;
    return $node;
  }

  public function getNode(int $id): ?Node
  {
    return $this->nodes[$id] ?? null;
  }

  public function getEdge(int $id): ?Edge
  {
    return $this->edges[$id] ?? null;
  }

  public function getCountNodes(): int
  {
    return count($this->nodes);
  }

}



/*$path = 'data.json';
$graph = new Graph();
$graph->createFromIncidenceMatrix(new DataFromFile($path));
echo "<pre>";
//print_r($graph);
print_r($graph->getNode(0)->getNextNodes($graph));
print_r($graph->getNode(1)->getNextNodes($graph));
print_r($graph->getNode(2)->getNextNodes($graph));
print_r($graph->getNode(3)->getNextNodes($graph));
print_r($graph->getNode(4)->getNextNodes($graph));
print_r($graph->getNode(5)->getNextNodes($graph));*/