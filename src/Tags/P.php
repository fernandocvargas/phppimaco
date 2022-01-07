<?php
declare(strict_types = 1);
namespace Proner\PhpPimaco\Tags;

class P
{
    private $content;
    private $size;
    private $bold;
    private $margin;

    /**
     * P constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
        $this->bold = false;
    }

    /**
     * @param float $size
     * @return $this
     */
    public function setSize(float $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return $this
     */
    public function b()
    {
        $this->bold = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function br()
    {
        $this->content .= "<br>";
        return $this;
    }

    /**
     * @param array $margin 
     * @return $this 
     */
    public function margin(array $margin)
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $tag = "span";
        if ($this->size !== null) {
            $style[] = "font-size: {$this->size}mm";
        }
        if ($this->bold === true) {
            $style[] = "font-weight: bold";
        }
        if (!empty($this->margin)) {
            $margin = \implode("mm ", $this->margin);
            $style[] = "margin: {$margin}mm";
        }

        if (!empty($style)) {
            $content = "<{$tag} style='".implode(";", $style).";'>{$this->content}</{$tag}>";
        } else {
            $content = "<{$tag}>{$this->content}</{$tag}>";
        }
        return $content;
    }
}
