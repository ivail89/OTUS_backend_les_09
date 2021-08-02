<?php


class Edge
{
  private Node $from;
  private Node $to;
  private int $cost;

  public function __construct(Node $from, Node $to, int $cost)
  {
    $this->from = $from;
    $this->to   = $to;
    $this->cost = $cost;
  }

  /**
   * @return Node
   */
  public function getTo(): Node
  {
    return $this->to;
  }

  /**
   * @return int
   */
  public function getCost(): int
  {
    return $this->cost;
  }

}