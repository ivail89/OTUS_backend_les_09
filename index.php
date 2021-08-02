#!/usr/bin/php
<?php

spl_autoload_register(function ($class_name) {
  require_once $class_name . '.php';
});

$options = getopt('p:', ['path:', 'from::']);
if (empty($options)) {
  die('Укажите обязательные параметры' . PHP_EOL);
}

$path = ($options['path']) ?? ($options['p']);

$graph = new Graph();
$graph->createFromIncidenceMatrix(new DataFromFile($path));

$from = $options['from'] ?? 0; // начинаем с какого узла обход
$count_nodes = $graph->getCountNodes();
if (!is_numeric($from) || $from < 0 || $from > $count_nodes - 1) {
  die('Головной узел указан некорректно');
}

$nodes = array_fill(0, $count_nodes, [
  'cost'    => PHP_INT_MAX,
  'route'   => null,
  'visited' => false
]);

$nodes [$from] = [
  'cost'    => 0,
  'route'   => (string)$from,
  'visited' => true
];

$current = $from;
$has_next = false;

while (!$has_next) {
  $next = $graph->getNode($current)->getNextNodes($graph);
  $has_next = true;
  $another = [
    'id'       => null,
    'new_cost' => PHP_INT_MAX
  ];
  foreach ($next as $n) {
    if (!$nodes[$n['id']]['visited']) {
      $new_cost = $nodes[$current]['cost'] + $n['cost'];
      if ($new_cost < $nodes[$n['id']]['cost']) {
        $nodes [$n['id']] = [
          'cost'    => $new_cost,
          'route'   => $nodes[$current]['route'] . ' => ' . $n['id'],
          'visited' => false
        ];
      }
      if ($nodes[$n['id']]['cost'] < $another['new_cost']) {
        $another = [
          'id'       => $n['id'],
          'new_cost' => $nodes[$n['id']]['cost']
        ];
      }
    }
  }
  if (!is_null($another['id'])) {
    $current                    = $another['id'];
    $nodes[$current]['visited'] = true;
    $has_next                   = false;
  }
}

echo "<pre>";
print_r($nodes);