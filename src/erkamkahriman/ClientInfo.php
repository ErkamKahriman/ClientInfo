<?php

namespace erkamkahriman;

use pocketmine\command\overload\CommandParameter;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class ClientInfo extends PluginBase {

    public function onEnable(){
        $this->getServer()->getCommandMap()->register("cinfo", new ClientInfoCommand("cinfo", $this));
        $this->getServer()->getCommandMap()->getCommand("cinfo")->getOverload("default")->setParameter(0, new CommandParameter("spieler", CommandParameter::TYPE_TARGET, false));
        $this->getServer()->getCommandMap()->getCommand("cinfo")->setDescription("Get Informations about a Client");
        $this->getServer()->getCommandMap()->getCommand("cinfo")->setAliases(array("clientinfo"));
        $this->getLogger()->info(C::GREEN . "Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED . "Disabled.");
    }
}