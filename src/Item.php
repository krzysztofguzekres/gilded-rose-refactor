<?php

declare(strict_types=1);

namespace App;

final class Item
{
    public const AGED_BRIE = 'Aged Brie';
    public const BACKSTAGE_PASS = 'Backstage passes to a TAFKAL80ETC concert';
    public const SULFURAS_HAND_OF_RAGNAROS = 'Sulfuras, Hand of Ragnaros';
    public const ELIXIR_OF_MONGOOSE = 'Elixir of the Mongoose';
    
    function __construct(public readonly string $name, public int $sell_in, public int $quality) {}

    public function __toString()
    {
        return sprintf("{%s}, {%d}, {%d}", $this->name, $this->sell_in, $this->quality);
    }
}
