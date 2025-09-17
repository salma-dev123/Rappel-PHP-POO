<?php 
set_error_handler(function ($severity, $message, $file, $line) {
    //Chaque fois qu’un warning/notice survient, cette fonction est appelée.
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    echo $undefinedVariable; // normalement un Notice
} catch (ErrorException $e) {
    echo "Erreur capturée : " . $e->getMessage();
}
