<?php
declare(strict_types=1);

$articles = [
  ['id'=>1,'title'=>'Intro Laravel','category'=>'php','views'=>120,'author'=>'Amina','published'=>true,  'tags'=>['php','laravel']],
  ['id'=>2,'title'=>'PHP 8 en pratique','category'=>'php','views'=>300,'author'=>'Yassine','published'=>true,  'tags'=>['php']],
  ['id'=>3,'title'=>'Composer & Autoload','category'=>'outils','views'=>90,'author'=>'Amina','published'=>false, 'tags'=>['composer','php']],
  ['id'=>4,'title'=>'Validation FormRequest','category'=>'laravel','views'=>210,'author'=>'Sara','published'=>true,  'tags'=>['laravel','validation']],
];
//Ce code définit un tableau $articles contenant 4 articles, chacun avec son id, titre, catégorie, nombre de vues, auteur, état de publication et une liste des tags //

function slugify(string $title): string {
// Cette fonction transforme un titre en "slug" (version simplifiée pour les URLs).
// Exemple : "Intro Laravel !" devient "intro-laravel".
    $slug = strtolower($title);                  // Met tout en minuscules
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug); // Remplace caractères spéciaux/espaces par des tirets
    return trim($slug, '-');    // Supprime les tirets en début et fin
}

$published = array_values(
  array_filter($articles, fn(array $a) => $a['published'] ?? false)
);
// On filtre la liste des articles pour garder seulement ceux publiés (`published = true`).
// `array_filter` enlève les articles non publiés.
// `array_values` réindexe le tableau pour que les clés soient 0,1,2...

$light = array_map(
  // On transforme la liste des articles publiés en une version "allégée".
  fn(array $a) => [
    'id'    => $a['id'],
    'title' => $a['title'],
    'slug'  => slugify($a['title']),//on génère un slug à partir du titre avec la fonction `slugify`.
    'views' => $a['views'],
  ],
  // Pour chaque article : on garde seulement l'id, le titre, les vues,
  $published
);

$top = $light; // On copie la liste allégée dans $top pour la trier sans modifier l'originale.
usort($top, fn($a, $b) => $b['views'] <=> $a['views']); // Ensuite, on trie les articles du plus vu au moins vu grâce à 'usort'.
$top3 = array_slice($top, 0, 3); // Enfin, on prend seulement les 3 premiers éléments avec 'array_slice' pour obtenir le Top 3.


$byAuthor = array_reduce(
  // On calcule le nombre d'articles publiés par chaque auteur.
  // 'array_reduce' parcourt chaque article publié et incrémente un compteur pour l'auteur correspondant.
  $published,
  function(array $acc, array $a): array {
      $author = $a['author'];
      $acc[$author] = ($acc[$author] ?? 0) + 1;
      return $acc;
  // Résultat : un tableau associatif $byAuthor où la clé est l'auteur et la valeur est le nombre d'articles.
  },
  []
);

$allTags = array_merge(...array_map(fn($a) => $a['tags'], $published));
// On crée une liste de tous les tags des articles publiés.
// 'array_map' récupère les tags de chaque article, puis 'array_merge(... )' les fusionne en un seul tableau.
$tagFreq = array_reduce(
// Ensuite, 'array_reduce' compte combien de fois chaque tag apparaît.
  $allTags,
  function(array $acc, string $tag): array {
      $acc[$tag] = ($acc[$tag] ?? 0) + 1;
      return $acc;
  },
  []
// Résultat : un tableau $tagFreq où la clé est le nom du tag et la valeur est sa fréquence d'apparition.
);

// On affiche les résultats obtenus :

echo "Top 3 (views):\n";
foreach ($top3 as $a) {
  echo "- {$a['title']} ({$a['views']} vues) — {$a['slug']}\n";
}
//Top 3 des articles les plus vus avec le titre, le nombre de vues et le slug.

echo "\nPar auteur:\n";
foreach ($byAuthor as $author => $count) {
  echo "- $author: $count article(s)\n";
}
//Nombre d'articles publiés par auteur.

echo "\nTags:\n";
foreach ($tagFreq as $tag => $count) {
  echo "- $tag: $count\n";
}
//Fréquence d'apparition de chaque tag.




