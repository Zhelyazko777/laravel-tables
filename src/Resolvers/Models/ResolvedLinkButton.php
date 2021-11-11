<?php

namespace Zhelyazko777\Tables\Resolvers\Models;

use Zhelyazko777\Tables\Resolvers\Models\Abstractions\BaseResolvedButton;

class ResolvedLinkButton extends BaseResolvedButton
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
     * @return self
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;
        return $this;
    }
}