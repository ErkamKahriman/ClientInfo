<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\plugin\PluginBase;

class ClientInfo extends PluginBase {

    /** @var ClientInfo $instance */
    private static $instance;

    /** @var array $deviceos */
    public static $deviceos = [];
    /** @var array $devicemodel */
    public static $devicemodel = [];

    public function onEnable(){
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("ClientInfo", new ClientInfoCommand($this));
    }

    public static function getInstance(): ClientInfo{
        return self::$instance;
    }

    public function getDeviceModel(string $name){
        return ClientInfo::$devicemodel[$name];
    }

    public function getDeviceOS(string $name): int{
        return ClientInfo::$deviceos[$name];
    }
}