<?php

namespace Yumerov\MaxiBot\Mocks\Traits;

use Yumerov\MaxiBot\DTO\EnvDTO;

trait EnvDTOTrait
{


    public function createEnvDTO(string $goodMorningChannels = '[]'): EnvDTO
    {
        return new EnvDTO([
            'DISCORD_TOKEN' => '0xtoken',
            'GOOD_MORNING_CHANNELS' => $goodMorningChannels,
            'MAINTAINER' => '1',
            'ALLOWED_SERVERS' => '["2"]',
            'MAINTAINER_ONLY_MODE' => 'true',
        ]);
    }
}
