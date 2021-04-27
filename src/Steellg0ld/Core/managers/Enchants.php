<?php

namespace Steellg0ld\Core\managers;

use pocketmine\item\enchantment\Enchantment;

class Enchants{
    public function init(){
        Enchantment::registerEnchantment(new Enchantment(100, "Robbery", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE,1));
        Enchantment::registerEnchantment(new Enchantment(101, "Explosion", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE,1));
    }
}