<?php
declare(strict_types=1);

/** @return array<mixed> */
function loadJson(string $path): array {
  $raw = @file_get_contents($path); //lire le fichier 
  if ($raw === false) {
    throw new RuntimeException("Fichier introuvable ou illisible: $path");
  }
  try {
    /** @var array<mixed> $data */
    $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR); //tronsformer le json en tableau associatif
    return $data;
  } catch (JsonException $e) {
    throw new RuntimeException("JSON invalide dans $path", previous: $e);
  }
}

/** @param array<mixed> $data */
function saveJson(string $path, array $data): void {
  $dir = dirname($path); //affiche le dossier du
  if (!is_dir($dir)) { mkdir($dir, 0777, true); }//crée le fichier s'il n'existe pas 

  try {
    $json = json_encode(
      $data,
      JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
    ); //tronsfomer le tableau associatif en json
    if ($json === false) {
      throw new RuntimeException("Échec d'encodage JSON (retour false)."); 
    }
  } catch (Throwable $e) {
    throw new RuntimeException("Encodage JSON impossible", previous: $e); //gere les erreurs
  }

  $ok = @file_put_contents($path, $json . PHP_EOL, LOCK_EX); //écrire le json dans le fichier
  if ($ok === false) {
    throw new RuntimeException("Écriture impossible: $path"); //gere les erreurs
  }
}
