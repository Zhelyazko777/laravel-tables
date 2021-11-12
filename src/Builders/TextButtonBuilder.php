<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\TextButtonConfig;

class TextButtonBuilder extends BaseButtonBuilder
{
    public function __construct()
    {
        $this->config = new TextButtonConfig();
    }
}