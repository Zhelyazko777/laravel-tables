<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;
use Zhelyazko777\Tables\Builders\Models\LinkButtonConfig;

class LinkButtonBuilder extends BaseButtonBuilder
{
    /**
     * @var LinkButtonConfig
     */
    protected BaseButtonConfig $config;

    public function __construct()
    {
        $this->config = new LinkButtonConfig();
    }

    public function onClickGoTo(string $route): self
    {
        $this->config->setRoute($route);
        return  $this;
    }
}
