<?php

namespace Steellg0ld\Core\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use Steellg0ld\Core\managers\Spells;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class SpellsBookUI{
    public static function openBook(Player $player){
        {
            $form = new SimpleForm(
                function (Player $p, $data) {
                    if ($data === null) {
                    } else {
                        if($p->getInventory()->contains(Item::get(ItemIds::DIAMOND_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::GOLDEN_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::IRON_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::STONE_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::WOODEN_SWORD))){
                            if($p->getStats()["xp"] >= Spells::SPELLS[$data]["xp_need"]) {
                                $p->sendMessage(Plugin::PREFIX . " ".Plugin::SECOND_COLOR."Le sort ".Plugin::BASE_COLOR.Spells::SPELLS[$data]["name"].Plugin::SECOND_COLOR." a été appliqué sur votre épée, faite des dégats à des adversaire en étant accroupi pour lancer le sort");
                            }else{
                                $p->sendMessage(Plugin::PREFIX_ERROR . " ".Plugin::SECOND_COLOR."Vous n'avez pas assez d'experience pour utiliser ce sort");
                            }
                        }else{
                            $p->sendMessage(Plugin::PREFIX_ERROR . " ".Plugin::SECOND_COLOR."Vous n'avez pas d'épée dans votre inventaire");
                        }
                    }
                }
            );

            $form->setTitle("- SPELLS BOOK -");
            $form->setContent(Plugin::PREFIX." ".Plugin::SECOND_COLOR . "Voici la liste des sorts, améliorer votre niveau pour en débloquer plus\n\n§b- Mana: " . $player->mana);
            foreach (Spells::SPELLS as $spell){
                $locked = ($player->getStats()["xp"] >= $spell["xp_need"] ? "§lDÉBLOQUER" : "§lBLOQUER");
                $form->addButton($spell["name"] ."\n". $locked,0,$spell["image"]);
            }
            $player->sendForm($form);
        }
    }
}