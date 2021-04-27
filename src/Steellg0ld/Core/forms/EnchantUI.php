<?php

namespace Steellg0ld\Core\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class EnchantUI { // TODO (just prepare)
    public static function openEnchantUI(Player $player){
        {
            $form = new SimpleForm(
                function (Player $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 2:
                                $enchant = new EnchantmentInstance(Enchantment::getEnchantment(100));
                                $p->getInventory()->getItemInHand()->addEnchantment($enchant);
                                break;
                        }
                    }
                }
            );

            $item = $player->getInventory()->getItemInHand()->getName();
            $count = 0;

            $form->setTitle("- ENCHANTING TABLE -");
            $form->setContent(Plugin::PREFIX . Plugin::SECOND_COLOR . " Voici les enchantements disponible pour votre item ".Plugin::BASE_COLOR.$item.Plugin::SECOND_COLOR.": ".Plugin::BASE_COLOR."$count");
            $form->addButton("Enchantements ensorcelées",0,"textures/spells/book_enchanted");
            $form->addButton("Enchantements disponibles ($count)",0,"textures/items/book_enchanted");
            $form->addButton("test",0,"textures/spells/book_enchanted");
            $player->sendForm($form);
        }
    }
}