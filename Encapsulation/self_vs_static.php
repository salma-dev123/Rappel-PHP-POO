<?php
class Base {
  public static function who(): string { return 'Base'; }
  public static function make(): static { return new static(); } // LSB
  public function type(): string { return static::who(); }       // LSB
}

class Child extends Base {
  public static function who(): string { return 'Child'; }
}

echo (new Child())->type();            // "Child"
var_dump(Child::make() instanceof Child); // true

// self:: → réfère toujours à la classe où le code est écrit (ici Base)
// static:: → utilise le "Late Static Binding" : prend en compte la classe appelante (ici Child)
// Donc : 
// (new Child())->type() appelle static::who() => "Child"
// Child::make() crée new static() => instance de Child (et pas Base)
