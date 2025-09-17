<?php
try {
  // ...
} catch (JsonException|InvalidArgumentException $e) {
  // traitement commun (ex. message + journalisation)
} catch (Exception $e) {
  // filet de sécurité pour autres exceptions
}

// Résumé de flux 
//1.php execute le try.
//2.Une exception se produit.
//3.PHP cherche le premier catch qui correspond :
     //Si JsonException ou InvalidArgumentException → premier bloc
     //Sinon → second bloc (Exception générale).
//4.Si aucune exception → aucun catch n’est exécuté.