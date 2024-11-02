<?php

declare(strict_types=1);

use App\GildedRose;
use App\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @dataProvider itemsProvider
     */
    public function testUpdateQualityTest(string $name, int $sellIn, int $quality, int $expectedSellIn, int $expectedQuality): void
    {
        $item = new Item($name, $sellIn, $quality);

        (new GildedRose())->updateQuality($item);

        $this->assertEquals($expectedSellIn, $item->sell_in);
        $this->assertEquals($expectedQuality, $item->quality);
    }

    public function itemsProvider(): array
    {
        return [
            'Aged Brie before sell in date' => [Item::AGED_BRIE, 10, 10, 9, 11],
            'Aged Brie sell in date' => [Item::AGED_BRIE, 0, 10, -1, 12],
            'Aged Brie after sell in date' => [Item::AGED_BRIE, -5, 10, -6, 12],
            'Aged Brie before sell in date with maximum quality' => [Item::AGED_BRIE, 5, 50, 4, 50],
            'Aged Brie sell in date near maximum quality' => [Item::AGED_BRIE, 0, 49, -1, 50],
            'Aged Brie sell in date with maximum quality' => [Item::AGED_BRIE, 0, 50, -1, 50],
            'Aged Brie after_sell in date with maximum quality' => [Item::AGED_BRIE, -10, 50, -11, 50],
            'Backstage passes before sell in date' => [Item::BACKSTAGE_PASS, 10, 10, 9, 12],
            'Backstage passes more than 10 days before sell in date' => [Item::BACKSTAGE_PASS, 11, 10, 10, 11],
            'Backstage passes five days before sell in date' => [Item::BACKSTAGE_PASS, 5, 10, 4, 13],
            'Backstage passes sell in date' => [Item::BACKSTAGE_PASS, 0, 10, -1, 0],
            'Backstage passes close to sell in date with maximum quality' => [Item::BACKSTAGE_PASS, 10, 50, 9, 50],
            'Backstage passes very close to sell in date with maximum quality' => [Item::BACKSTAGE_PASS, 5, 50, 4, 50],
            'Backstage passes after sell in date' => [Item::BACKSTAGE_PASS, -5, 50, -6, 0],
            'Sulfuras before sell in date' => [Item::SULFURAS_HAND_OF_RAGNAROS, 10, 80, 10, 80],
            'Sulfuras sell in date' => [Item::SULFURAS_HAND_OF_RAGNAROS, 0, 80, 0, 80],
            'Sulfuras after sell in date' => [Item::SULFURAS_HAND_OF_RAGNAROS, -1, 80, -1, 80],
            'Elixir of the Mongoose before sell in date' => [Item::ELIXIR_OF_MONGOOSE, 10, 10, 9, 9],
            'Elixir of the Mongoose sell in date' => [Item::ELIXIR_OF_MONGOOSE, 0, 10, -1, 8],
        ];
    }
}
