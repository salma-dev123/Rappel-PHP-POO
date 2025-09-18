<?php
declare(strict_types=1);

class Category {
    // Lecture seule après construction (PHP ≥ 8.1)
    public function __construct(
        public readonly string $name,
        public readonly ?string $color = null,
    ) {}
}

$cat = new Category('php', '#8892BF');
// $cat->name = 'autre'; // ❌ Erreur : propriété readonly
print_r($cat);