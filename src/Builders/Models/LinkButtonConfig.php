<?php

namespace Zhelyazko777\Tables\Builders\Models;

use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;

class LinkButtonConfig extends BaseButtonConfig
{
    private string $route = '';

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param  string  $route
     * @return LinkButtonConfig
     */
    public function setRoute(string $route): LinkButtonConfig
    {
        $this->route = $route;
        return $this;
    }
}
