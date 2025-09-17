<?php
declare(strict_types=1);

function riskyDivide(int $a, int $b): float {
  if ($b === 0) {
    throw new InvalidArgumentException('Division par zéro interdite.');
     // throw : permet de lancer une exception quand une erreur survient, pour interrompre le flux normal et signaler le problème
  }
  return $a / $b;
}

try {
  echo riskyDivide(10, 0);
  // try : contient le code qui peut provoquer une exception, à tester en toute sécurité
} catch (InvalidArgumentException $e) {
  echo "[WARN] " . $e->getMessage() . PHP_EOL;
  // catch : intercepte et gère l’exception lancée dans le try
} finally {
  echo "Toujours exécuté (libération de ressources, etc.)." . PHP_EOL;
  // finally : s’exécute toujours, qu’il y ait eu une exception ou non, utile pour libérer des ressources

}
