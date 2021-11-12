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

    /**
     * Sets a modal id
     * @param  string  $modalId
     * @return $this
     */
    public function withModalId(string $modalId): self
    {
        $this->config->setModalId($modalId);
        return $this;
    }

    /**
     * Adds a route to fire when modal is confirmed
     * @param  string  $actionRoute
     * @return $this
     */
    public function withActionRoute(string $actionRoute): self
    {
        $this->config->setModalActionRoute($actionRoute);
        return $this;
    }

    /**
     * Adds a modal heading text
     * @param  string  $modalHeadingText
     * @return $this
     */
    public function withModalHeadingText(string $modalHeadingText): self
    {
        $this->config->setModalHeadingText($modalHeadingText);
        return $this;
    }

    /**
     * Adds modal body text
     * @param  string  $modalBodyText
     * @return $this
     */
    public function withModalBodyText(string $modalBodyText): self
    {
        $this->config->setModalBodyText($modalBodyText);
        return $this;
    }

    /**
     * Adds text for the cancel button of the modal
     * @param  string  $cancelText
     * @return $this
     */
    public function withCancelText(string $cancelText): self
    {
        $this->config->setModalCancelText($cancelText);
        return $this;
    }

    /**
     * Adds text for the confirm button of the modal
     * @param  string  $submitText
     * @return $this
     */
    public function withSubmitText(string $submitText): self
    {
        $this->config->setModalSubmitText($submitText);
        return $this;
    }

    /**
     * Changes the color of the modal confirmation button
     * @param  string  $color
     * @return $this
     */
    public function withColor(string $color): self
    {
        $this->config->setModalColor($color);
        return $this;
    }
}
