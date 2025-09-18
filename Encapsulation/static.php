<?php
class Counter {
  private static int $count = 0;       // partagé par toutes les instances
  public function __construct() { self::$count++; }
  public static function count(): int { return self::$count; } // méthode de classe
}

new Counter(); new Counter();
echo Counter::count(); // 2
