<?php
function loadConfig(string $path): array {
  try {
    $json = file_get_contents($path); //Essaie de lire le contenu du fichier $path.
    if ($json === false) { //Si la lecture échoue, on lance une RuntimeException :
      throw new RuntimeException("Lecture impossible: $path");
    }
    return json_decode($json, true, 512, JSON_THROW_ON_ERROR); //Convertit le contenu JSON en tableau PHP.
    //JSON_THROW_ON_ERROR fait en sorte que json_decode lance une JsonException si le JSON est invalide
  } catch (JsonException $e) {
    throw new RuntimeException("JSON invalide dans $path", previous: $e);
    //Si le JSON est invalide, on attrape l’exception.on la relance sous forme de RuntimeException, avec un message plus clair .
  }
}

