<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;

class EventListener implements Listener {

    public function onPacketReceive(DataPacketReceiveEvent $event){
        $packet = $event->getPacket();
        if($packet instanceof LoginPacket){
            $name = strtolower($packet->username);
            if(!in_array($name, ClientInfo::$devicemodel)){
                ClientInfo::$devicemodel[$name] = $packet->clientData["DeviceModel"];
            }
            if(!in_array($name, ClientInfo::$deviceos)){
                ClientInfo::$deviceos[$name] = $packet->clientData["DeviceOS"];
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        if(in_array($name, ClientInfo::$devicemodel)){
            unset(ClientInfo::$devicemodel[$name]);
        }
        if(in_array($name, ClientInfo::$deviceos)){
            unset(ClientInfo::$deviceos[$name]);
        }
    }
}