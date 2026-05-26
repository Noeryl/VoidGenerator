<?php

declare(strict_types = 1);

namespace voidgenerator;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\BiomeIds;
use pocketmine\plugin\PluginBase;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\format\PalettedBlockArray;
use pocketmine\world\format\SubChunk;
use pocketmine\world\generator\Generator;
use pocketmine\world\generator\GeneratorManager;
use function rmdir;

final class VoidGenerator extends PluginBase{

    public const SPAWN_Y = 49;

    protected function onLoad() : void{
        rmdir($this->getDataFolder());

        $class = new class extends Generator{

            public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
                $chunk = new Chunk([], false);

                $biomeArray = new PalettedBlockArray(BiomeIds::PLAINS);
                foreach($chunk->getSubChunks() as $y => $subChunk){
                    $chunk->setSubChunk($y, new SubChunk(Block::EMPTY_STATE_ID, [], clone $biomeArray));
                }

                $stoneState = VanillaBlocks::STONE()->getStateId();
                $cobbleState = VanillaBlocks::COBBLESTONE()->getStateId();
                for($x = 0; $x < Chunk::EDGE_LENGTH; $x++){
                    for($z = 0; $z < Chunk::EDGE_LENGTH; $z++){
                        $worldX = ($chunkX * Chunk::EDGE_LENGTH) + $x;
                        $worldZ = ($chunkZ * Chunk::EDGE_LENGTH) + $z;

                        if($worldX >= -16 && $worldX <= 16 && $worldZ >= -16 && $worldZ <= 16){
                            $chunk->setBlockStateId($x, VoidGenerator::SPAWN_Y, $z, ($worldX === 0 && $worldZ === 0) ? $cobbleState : $stoneState);
                        }
                    }
                }

                $world->setChunk($chunkX, $chunkZ, $chunk);
            }

            public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
                //NOOP
            }
        };

        $manager = GeneratorManager::getInstance();
        $manager->addGenerator($class::class, 'void', fn() => null, true, true);
        $manager->addAlias('void', 'empty');
    }
}