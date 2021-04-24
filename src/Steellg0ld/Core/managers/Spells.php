<?php

namespace Steellg0ld\Core\managers;

use pocketmine\item\Item;
use pocketmine\item\ItemIds;

class Spells{

    const INCENDIOS_PLAYERS = [];

    const SPELLS = [
        0 => [
            "name" => "Reducto",
            "description" => "Faire diminuer la durabilité de l'item que l'adversaire à en main au moment du sort, à 3 de durabilité",
            "image" => "textures/spells/reducto",
            "xp_need" => 500
        ],
        1 => [
            "name" => "Incendio",
            "description" => "Mettre le feu à la personne frappée",
            "image" => "textures/spells/incendio",
            "xp_need" => 1000
        ],
        2 => [
            "name" => "Imobilis",
            "description" => "Immobilise la personne frappée pendant 2 seconde(s)",
            "image" => "textures/spells/imobilis",
            "xp_need" => 1500
        ],
        3 => [
            "name" => "Protego",
            "description" => "Vous ne subirez pas le prochain sort effectué sur vous",
            "image" => "textures/spells/protecto",
            "xp_need" => 2000
        ]
    ];

    /**
     * @param Item $item
     * @return Item
     * Enlever 3 de durabilité à l'objet tenu par l'ennemi frappé
     */
    public function Reducto(Item $item): Item {
        switch ($item->getId()) {
            case ItemIds::DIAMOND_SWORD:
                $item->setDamage(1562 - 3);
                break;
        }
        return $item->setDamage($item->getDamage());
    }

    /**
     * @param Item $item
     * @return Item
     * Faire que le feu se déplace la ou l'adversaire vas, pendant 30 secondes
     */
    public function Incendio(Item $item): Item {

    }
}