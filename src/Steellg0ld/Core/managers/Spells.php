<?php

namespace Steellg0ld\Core\managers;

use pocketmine\entity\Entity;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\math\Vector3;
use pocketmine\Server;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class Spells{

    const SPELLS = [
        0 => [
            "name" => "Reducto",
            "description" => "Faire diminuer la durabilité de l'item que l'adversaire à en main au moment du sort, à 3 de durabilité",
            "image" => "textures/spells/reducto",
            "xp_need" => 500,
            "mana_cost" => 60,
            "cooldown" => 30,
        ],
        1 => [
            "name" => "Incendio",
            "description" => "Mettre le feu à la personne frappée",
            "image" => "textures/spells/incendio",
            "xp_need" => 1000,
            "mana_cost" => 35,
            "cooldown" => 160,
        ],
        2 => [
            "name" => "Imobilis",
            "description" => "Immobilise la personne frappée pendant 2 seconde(s)",
            "image" => "textures/spells/imobilis",
            "xp_need" => 1500,
            "mana_cost" => 30,
            "cooldown" => 120,
        ],
        3 => [
            "name" => "Protego",
            "description" => "Vous ne subirez pas le prochain sort effectué sur vous",
            "image" => "textures/spells/protecto",
            "xp_need" => 2000,
            "mana_cost" => 50,
            "cooldown" => 120,
        ]
    ];

    /**
     * @param Entity $damager
     * @param Entity $victim
     */
    public function Protecto(Entity $damager, Entity $victim){
        if($damager instanceof Player AND $victim instanceof Player){
            $victim->protego = false;
            $victim->cooldown_spell = time() + 10;
            $victim->sendTip(Plugin::PREFIX . Plugin::SECOND_COLOR . " Votre protection à été détruite, car un utilisateur de sort à essayé d'en éxécuté un sur vous " . Plugin::PREFIX);
            $damager->sendTip(Plugin::PREFIX . Plugin::BASE_COLOR . " " .$victim->getName() . Plugin::SECOND_COLOR . " était protégé(e), vous n'avez donc pas pu utiliser votre sort sur cette personne " . Plugin::PREFIX);

            $vector = new Vector3(($damager->getX() - $victim->getX()), 1, ($damager->getZ() - $victim->getZ()));
            $vector->normalize()->multiply(10);
            $damager->setMotion($vector);
            
            $victim->getLevel()->addParticle(new ExplodeParticle($victim->asVector3()),Server::getInstance()->getOnlinePlayers());
        }
    }

    /**
     * @param Item $item
     * @return bool|Int
     * Modifier la durabilité à 3 de durabilité à l'objet tenu par l'ennemi frappé
     */
    public function Reducto(Item $item){
        if($item instanceof Durable){
            $item->applyDamage($item->getMaxDurability() - 3);
            return $item;
        }else{
            return $item;
        }
    }
}
