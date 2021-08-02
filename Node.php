<?php


class Node
{
  private int $id;
  private array $edges = [];

  public function __construct(int $id)
  {
    $this->id = $id;
  }

  public function addEdge(int $id_edge) : void
  {
    $this->edges [] = $id_edge;
  }

  /**
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  public function getNextNodes(Graph $graph): array
  {
    $next_nodes = [];
    foreach ($this->edges as $id_edge) {
      $edge = $graph->getEdge($id_edge);
      if ($edge instanceof Edge) {
        $next_nodes [] = [
          'id'   => $edge->getTo()->getId(),
          'cost' => $edge->getCost()
        ];
      } else {
        echo "Edge with id: $id_edge is null <br>";
      }
    }
    return $next_nodes;
  }

}
