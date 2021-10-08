<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;
use Zhelyazko777\Tables\Builders\Models\ModalButtonConfig;

class ModalButtonBuilder extends BaseButtonBuilder
{
    /**
     * @var ModalButtonConfig
     */
    protected BaseButtonConfig $config;

    public function __construct()
    {
        $this->config = new ModalButtonConfig();
    }

    public function withModalId(string $modalId): self
    {
        $this->config->setModalId($modalId);
        return $this;
    }

    public function withActionRoute(string $actionRoute): self
    {
        $this->config->setModalActionRoute($actionRoute);
        return $this;
    }

    public function withModalHeadingText(string $modalHeadingText): self
    {
        $this->config->setModalHeadingText($modalHeadingText);
        return $this;
    }

    public function withModalBodyText(string $modalBodyText): self
    {
        $this->config->setModalBodyText($modalBodyText);
        return $this;
    }

    public function withCancelText(string $cancelText): self
    {
        $this->config->setModalCancelText($cancelText);
        return $this;
    }

    public function withSubmitText(string $submitText): self
    {
        $this->config->setModalSubmitText($submitText);
        return $this;
    }

    public function withColor(string $color): self
    {
        $this->config->setModalColor($color);
        return $this;
    }
}
