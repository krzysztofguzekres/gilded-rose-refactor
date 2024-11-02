<?php

declare(strict_types=1);

namespace App;

final class GildedRose
{
    private const MAX_NORMAL_QUALITY = 50;
    private const MAX_LEGENDARY_QUALITY = 80;
    private const SELL_BY_DATE_EXPIRE = 0;
    private const SIX_DAYS = 6;
    private const ELEVEN_DAYS = 11;

    public function updateQuality(Item $item): void
    {
        switch ($item->name) {
            case Item::AGED_BRIE:
                $this->updateAgedBrieQuality($item);
                break;
            case Item::BACKSTAGE_PASS:
                $this->updateBackstagePassQuality($item);
                break;
            case Item::SULFURAS_HAND_OF_RAGNAROS:
                $this->updateLegendaryQuality($item);
                break;
            default:
                $this->updateDefaultQuality($item);
                break;
        }
    }

    private function updateAgedBrieQuality(Item $item): void
    {
        if ($item->quality < self::MAX_NORMAL_QUALITY) {
            $item->quality = $item->quality + 1;
        }

        $item->sell_in = $item->sell_in - 1;

        if ($item->sell_in < 0) {
            if ($item->quality < self::MAX_NORMAL_QUALITY) {
                $item->quality = $item->quality + 1;
            }
        }
    }

    private function updateBackstagePassQuality(Item $item): void
    {
        if ($item->quality < self::MAX_NORMAL_QUALITY) {
            $item->quality = $item->quality + 1;
            if ($item->sell_in < self::ELEVEN_DAYS) {
                if ($item->quality < self::MAX_NORMAL_QUALITY) {
                    $item->quality = $item->quality + 1;
                }
            }
            if ($item->sell_in < self::SIX_DAYS) {
                if ($item->quality < self::MAX_NORMAL_QUALITY) {
                    $item->quality = $item->quality + 1;
                }
            }
        }

        $item->sell_in = $item->sell_in - 1;

        if ($item->sell_in < self::SELL_BY_DATE_EXPIRE) {
            $item->quality = $item->quality - $item->quality;
        }
    }

    private function updateLegendaryQuality(Item $item): void
    {
        $item->quality = self::MAX_LEGENDARY_QUALITY;
    }

    private function updateDefaultQuality(Item $item): void
    {
        if ($item->quality > 0) {
            $item->quality = $item->quality - 1;
        }

        $item->sell_in = $item->sell_in - 1;

        if ($item->sell_in < 0) {
            if ($item->quality > 0) {
                $item->quality = $item->quality - 1;
            }
        }
    }
}
