<?php

namespace Yumerov\MaxiBot\Mocks\Traits;

use Yumerov\MaxiBot\DTO\EnvDTO;

trait EnvTrait
{

    private array $envData = [
        'DISCORD_TOKEN' => '0xtoken',
        'GOOD_MORNING_CHANNELS' => '["0"]',
        'MAINTAINER' => '1',
        'ALLOWED_SERVERS' => '["2"]',
        'MAINTAINER_ONLY_MODE' => 'true'
    ];

    protected function createEnvDTO(
        string $goodMorningChannels = '[]',
        string $maintainerOnlyMode = 'false',
        string $maintainer = '1'
    ): EnvDTO {
        return new EnvDTO([
            'DISCORD_TOKEN' => '0xtoken',
            'GOOD_MORNING_CHANNELS' => $goodMorningChannels,
            'MAINTAINER' => '1',
            'ALLOWED_SERVERS' => '["2"]',
            'MAINTAINER_ONLY_MODE' => $maintainerOnlyMode,
        ]);
    }

    protected function unsetEnv(array $keys): void
    {
        foreach ($keys as $key)
        {
            unset($_ENV[$key]);
        }
    }
}
