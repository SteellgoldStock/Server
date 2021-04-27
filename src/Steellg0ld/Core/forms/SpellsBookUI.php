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
                        switch ($data){
                            case 3:
                                $p->protego = true;
                                $p->mana = $p->mana - Spells::SPELLS[$data]["name"];
                                $p->cooldown_spell = Spells::SPELLS[$data]["cooldown"];
                                $p->sendMessage(Plugin::PREFIX . " ".Plugin::SECOND_COLOR."Le sort ".Plugin::BASE_COLOR.Spells::SPELLS[$data]["name"].Plugin::SECOND_COLOR." a été appliqué, vous êtes maintenant protégé(e) du prochain sort qu'un adversaire peut vous infliger");
                                break;
                            default:
                                if($p->getStats()["xp"] >= Spells::SPELLS[$data]["xp_need"]) {
                                    if($p->getInventory()->contains(Item::get(ItemIds::DIAMOND_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::GOLDEN_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::IRON_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::STONE_SWORD)) OR $p->getInventory()->contains(Item::get(ItemIds::WOODEN_SWORD))){
                                        $p->spell_applied = $data;
                                        $p->sendMessage(Plugin::PREFIX . " ".Plugin::SECOND_COLOR."Le sort ".Plugin::BASE_COLOR.Spells::SPELLS[$data]["name"].Plugin::SECOND_COLOR." a été appliqué sur votre épée, faite des dégats à des adversaire en étant accroupi pour lancer le sort");
                                    }else{
                                        $p->sendMessage(Plugin::PREFIX_ERROR . " ".Plugin::SECOND_COLOR."Vous n'avez pas d'épée dans votre inventaire");
                                    }
                                }else{
                                    $p->sendMessage(Plugin::PREFIX_ERROR . " ".Plugin::SECOND_COLOR."Vous n'avez pas assez d'experience pour utiliser ce sort");
                                }
                                break;
                        }
                    }
                }
            );

            $form->setTitle("- SPELLS BOOK -");
            // TODO: Integrate a system "Custom Partys" will players can set free authorized spells and no locked (for custom parties)
            $form->setContent(Plugin::PREFIX." ". Plugin::SECOND_COLOR . "Voici la liste des sorts, améliorer votre niveau pour en débloquer plus\n".Plugin::PREFIX." ".Plugin::SECOND_COLOR . "Votre niveau de sorcier: " . Plugin::BASE_COLOR . $player->getLevelByXP($player->getStats()["xp"]));
            foreach (Spells::SPELLS as $spell){
                $locked = ($player->getStats()["xp"] >= $spell["xp_need"] ? "§lDÉBLOQUER" : "§lBLOQUER");
                $form->addButton($spell["name"] ."\n". $locked,0,$spell["image"]);
            }
            $player->sendForm($form);
        }
    }
}