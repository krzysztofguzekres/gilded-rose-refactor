<?php

declare(strict_types=1);

namespace App;

final class GildedRose
{
    private const MAX_NORMAL_QUALITY = 50;
    private const MAX_LEGENDARY_QUALITY = 80;
    private const MIN_QUALITY = 0;
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
                $this->setLegendaryQuality($item);
                break;
            default:
                $this->updateDefaultQuality($item);
                break;
        }
    }

    private function updateAgedBrieQuality(Item $item): void
    {
        $this->updateSellIn($item);
        $item->quality += $item->sell_in < self::SELL_BY_DATE_EXPIRE ? 2 : 1;
        $this->ensureMaxQuality($item);
    }

    private function updateBackstagePassQuality(Item $item): void
    { 
        $item->quality += 1;
        if ($item->sell_in < self::ELEVEN_DAYS) {
            $item->quality += 1;
        }
        if ($item->sell_in < self::SIX_DAYS) {
            $item->quality += 1;
        }

        $this->ensureMaxQuality($item);

        $this->updateSellIn($item);
        if ($item->sell_in < self::SELL_BY_DATE_EXPIRE) {
            $item->quality = self::MIN_QUALITY;
        }
    }

    private function setLegendaryQuality(Item $item): void
    {
        $item->quality = self::MAX_LEGENDARY_QUALITY;
    }

    private function updateDefaultQuality(Item $item): void
    {
        $this->updateSellIn($item);
        $item->quality -= ($item->sell_in < self::SELL_BY_DATE_EXPIRE) ? 2 : 1;
        $this->ensureNonNegativeQuality($item);
    }

    private function updateSellIn(Item $item): void
    {
        $item->sell_in -= 1;
    }

    private function ensureMaxQuality(Item $item): void
    {
        $item->quality = min($item->quality, self::MAX_NORMAL_QUALITY);
    }

    private function ensureNonNegativeQuality(Item $item): void
    {
        $item->quality = max($item->quality, self::MIN_QUALITY);
    }
}
