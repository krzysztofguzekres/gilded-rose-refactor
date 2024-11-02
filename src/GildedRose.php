<?php

declare(strict_types=1);

namespace App;

final class GildedRose
{
    public function updateQuality(Item $item)
    {
        if ($item->name != Item::AGED_BRIE and $item->name != Item::BACKSTAGE_PASS) {
            if ($item->quality > 0) {
                if ($item->name != Item::SULFURAS_HAND_OF_RAGNAROS) {
                    $item->quality = $item->quality - 1;
                } else {
                    $item->quality = 80;
                }
            }
        } else {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
                if ($item->name == Item::BACKSTAGE_PASS) {
                    if ($item->sell_in < 11) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                    if ($item->sell_in < 6) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
            }
        }

        if ($item->name != Item::SULFURAS_HAND_OF_RAGNAROS) {
            $item->sell_in = $item->sell_in - 1;
        }

        if ($item->sell_in < 0) {
            if ($item->name != Item::AGED_BRIE) {
                if ($item->name != Item::BACKSTAGE_PASS) {
                    if ($item->quality > 0) {
                        if ($item->name != Item::SULFURAS_HAND_OF_RAGNAROS) {
                            $item->quality = $item->quality - 1;
                        }
                    }
                } else {
                    $item->quality = $item->quality - $item->quality;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }
            }
        }
    }

}