<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\command\overload\CommandParameter;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class ClientInfo extends PluginBase {

    public function onEnable(){
        $cmdmap = $this->getServer()->getCommandMap();
        $cmdmap->register("cinfo", new ClientInfoCommand("cinfo", $this));
        $cinfo = $cmdmap->getCommand("cinfo");
        $cinfo->setDescription("Get Informations about a Client.");
        $cinfo->getOverload("default")->setParameter(0, new CommandParameter("spieler", CommandParameter::ARG_TYPE_TARGET, false));
        $cinfo->setAliases(["clientinfo"]);
        $this->getLogger()->info(C::GREEN . "Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED . "Disabled.");
    }
}