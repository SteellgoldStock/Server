<?php

namespace Steellg0ld\Core\managers;

use pocketmine\item\Item;

class Spells{
    const SPELLS = [
        1 => [
            "name" => "Reducto",
            "description" => "Faire diminuer la durabilité de l'item que l'adversaire à en main au moment du sort, à 3 de durabilité"
        ]
    ];

    /**
     * @param Item $item
     * @return Item
     * Faire diminuer la durabilité de l'item que l'adversaire à en main au moment du sort, à 3 de durabilité
     */
    public function Reducto(Item $item): Item{
        return $item->setDamage($item->getDamage() - ($item->getDamage() - 3));
    }
}