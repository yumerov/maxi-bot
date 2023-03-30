<?php

namespace Yumerov\MaxiBot\DTO;

class EnvDTO
{

    public readonly string $discordToken;
    public readonly string $goodMorningChannels;
    public readonly string $maintainer;
    public readonly string $maintainerOnlyMode;
    public readonly string $allowedServers;

    public function __construct(array $env)
    {
        $this->discordToken = $env['DISCORD_TOKEN'];
        $this->goodMorningChannels = $env['GOOD_MORNING_CHANNELS'];
        $this->maintainer = $env['MAINTAINER'];
        $this->maintainerOnlyMode = $env['MAINTAINER_ONLY_MODE'];
        $this->allowedServers = $env['ALLOWED_SERVERS'];
    }
}
