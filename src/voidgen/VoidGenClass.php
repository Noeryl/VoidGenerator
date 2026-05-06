<?php

declare(strict_types = 1);

namespace voidgen;

use pocketmine\world\generator\Generator;
use pocketmine\world\ChunkManager;
use pocketmine\block\VanillaBlocks;

final class VoidGenClass extends Generator{

    public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
        $chunk = $world->getChunk($chunkX, $chunkZ);
        if($chunkX === 0 && $chunkZ === 0){
            $chunk->setBlockStateId(0, 49, 0, VanillaBlocks::GRASS()->getStateId());
        }
    }

    public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
        //NOOP
    }
}
