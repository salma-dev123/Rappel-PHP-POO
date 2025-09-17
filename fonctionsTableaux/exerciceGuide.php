<?php
declare(strict_types=1);
//affichons juste les articles publiées 
$published = array_values(array_filter($articles, fn($a) => $a['published'] ?? false));

//normalisons avec array_map 
$normalized = array_map(
  fn($a) => [
    'id'       => $a['id'],
    'slug'     => slugify($a['title']),
    'views'    => $a['views'],
    'author'   => $a['author'],
    'category' => $a['category'],
  ],
  $published
);
//trions par vues décroissantes
usort($normalized, fn($x, $y) => $y['views'] <=> $x['views']);

//calculons la somme 
$summary = array_reduce(
  $published,
  function(array $acc, array $a): array {
      $acc['count']      = ($acc['count'] ?? 0) + 1;
      $acc['views_sum']  = ($acc['views_sum'] ?? 0) + $a['views'];
      $cat = $a['category'];
      $acc['by_category'][$cat] = ($acc['by_category'][$cat] ?? 0) + 1;
      return $acc;
  },
  ['count'=>0, 'views_sum'=>0, 'by_category'=>[]]
);

//affichons le résultat
print_r($normalized);
print_r($summary);