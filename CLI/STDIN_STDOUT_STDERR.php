<?php
fwrite(STDOUT, "OK\n");              // sortie normale
fwrite(STDERR, "Erreur: fichier introuvable\n"); // sortie erreur
exit(1); // 0=succès, 1=erreur (shell: `$?`)

if (!file_exists("data.json")) {
    fwrite(STDERR, "Erreur: fichier manquant\n");
    exit(1); // code erreur
}

echo "Traitement OK\n";
exit(0); // succès

