<?php

namespace Steellg0ld\Core\forms;

use jojoe77777\FormAPI\SimpleForm;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class NaviguateUI
{
    public static function openCompassUI(Player $player)
    {
        {
            $form = new SimpleForm(
                function (Player $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                $p->sendMessage(Plugin::PREFIX . Plugin::SECOND_COLOR . " Connexion vers le jeu: " . Plugin::BASE_COLOR . "Magie & Combat" . Plugin::SECOND_COLOR . " !");
                                // TODO: Auto servers for games
                                Plugin::getInstance()->getGame("COMBAT")->addPlayer($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle("- PRACTICE -");
            $form->setContent(Plugin::PREFIX . Plugin::SECOND_COLOR . " Bienvenu(e) sur " . Plugin::BASE_COLOR . Plugin::SERVER_NAME . Plugin::SECOND_COLOR . ", voici les jeux disponibles sur cette interface\n");
            $form->addButton(Combat::NAME,SimpleForm::IMAGE_TYPE_PATH,"textures/items/spell_book");
            $player->sendForm($form);
        }
    }
}