<?php

declare(strict_types = 1);

namespace voidgen;

use pocketmine\plugin\PluginBase;
use pocketmine\world\generator\GeneratorManager;

final class VoidGenerator extends PluginBase{

    protected function onLoad() : void{
        $manager = GeneratorManager::getInstance();
        $manager->addGenerator(VoidGenClass::class, "void", fn() => null);
        $manager->addAlias("void", "empty");
    }
}