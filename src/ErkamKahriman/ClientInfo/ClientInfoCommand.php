<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\types\CommandParameter;
use pocketmine\Player;

class ClientInfoCommand extends PluginCommand {

    public function __construct(ClientInfo $plugin){
        parent::__construct("clientinfo", $plugin);
        $this->setPermission("clientinfo");
        $this->setDescription("Get Informations about a Client.");
        if(ClientInfo::getInstance()->getServer()->getName() === "Altay"){
            $this->setParameter(new CommandParameter("player", CommandParameter::ARG_TYPE_TARGET, false), 0);
        }
        $this->setAliases(["cinfo"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender->hasPermission("clientinfo")){
            if(isset($args[0]) && !empty($args[0])){
                $spieler = ClientInfo::getInstance()->getServer()->getPlayer($args[0]);
                if($spieler !== null){
                    $sender->sendMessage("§7» §9Client Info §7«");
                    $sender->sendMessage("§eUsername: §f".$spieler->getName());
                    $sender->sendMessage("§eNameTag: §f".$spieler->getNameTag());
                    $sender->sendMessage("§eDeviceOS: §f".$this->getOS($spieler));
                    $sender->sendMessage("§eDeviceModel: §f".ClientInfo::getInstance()->getDeviceModel($spieler->getName()));
                    $sender->sendMessage("§eLanguage: §f".$spieler->getLocale());
                    $sender->sendMessage("§eIP: §f".$spieler->getAddress());
                } else{
                    $sender->sendMessage("§cPlayer couldn't be found.");
                }
            } else{
                $sender->sendMessage("§eYou need to specify a player.");
            }
        } else{
            $sender->sendMessage("§cYou don't have permissions to do that.");
        }
    }

    public function getOS(Player $player){
        switch(ClientInfo::getInstance()->getDeviceOS($player->getName())){
            case 1:
                return "Android";
            case 2:
                return "IOS";
            case 3:
                return "Mac";
            case 4:
                return "FireOS";
            case 7:
                return "Windows";
            case 9:
                return "Dedicated";
            default:
                return "Unknown";
        }
    }
}
