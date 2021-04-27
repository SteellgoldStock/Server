<?php

namespace Steellg0ld\Core\forms;

use jojoe77777\FormAPI\CustomForm;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class SettingsUI{
    public static function openSettings(Player $player){
        {
            $form = new CustomForm(
                function (Player $p, $data) {
                    if ($data !== null) {
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "show_os", $data[1]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "receive_messages", $data[2]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "reconnect", $data[3]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "auto_respawn", $data[4]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "cps", $data[5]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "ping", $data[6]);
                        if($p->isAllowed(2,3)){
                            Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "username", $data[7]);
                        }
                        if ($p->isAllowed(1,4)) {
                            Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "size", $data[8]);
                            $p->setScale($data[7]);
                        }
                        if($p->isAllowed(1,2,3,4)){
                            Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "particles", $data[9]);
                        }

                        if ($p->isAllowed(1,2,3,4)) {
                            Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "custom_os", $data[10]);
                        } else {
                            $p->sendMessage(Plugin::PREFIX_ERROR . Plugin::SECOND_COLOR . " Vous n'avez pas le grade requis, vous n'avez donc pas pu activer/désactiver certains paramètre(s)");
                        }

                        // TODO : Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "pet", $data[10]);
                        $p->sendMessage(Plugin::PREFIX . Plugin::SECOND_COLOR . " Vous venez de modifier vos paramètres avec succès !");
                    }
                }
            );

            $form->setTitle("- PRACTICE -");
            $form->addLabel(Plugin::PREFIX . Plugin::SECOND_COLOR . " Bienvenu(e) sur " . Plugin::BASE_COLOR . Plugin::SERVER_NAME . Plugin::SECOND_COLOR . ", voici les paramètres disponibles sur cette interface\n");
            $form->addToggle("Show your OS",$player->getSettings()["show_os"]);
            $form->addToggle("Can receive private messages", $player->getSettings()["receive_messages"]);
            $form->addToggle("Auto reconnect when server restart", $player->getSettings()["reconnect"]);
            $form->addToggle("Auto respawn on death", $player->getSettings()["auto_respawn"]);
            $form->addToggle("Show CPS",$player->getSettings()["cps"]);
            $form->addToggle("Show Ping",$player->getSettings()["ping"]);
            $form->addInput("Custom username", $player->getName(),$player->getSettings()["username"]);
            $form->addSlider("Custom size", 1, 3,1,$player->getSettings()["size"]);
            $form->addSlider("Particules", 0, 3,1,$player->getSettings()["particles"]);
            $form->addDropdown("Custom OS", ["Windows", "Android"], $player->getSettings()["custom_os"]);
            // $form->addDropdown("Choose pet", ["Cat", "Dog", "Squid", "Ghast", "Wither", "Skeleton", "Zombie", "Money"],$player->getSettings()["pet"]);
            $player->sendForm($form);
        }
    }
}