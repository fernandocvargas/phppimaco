<?php
declare(strict_types = 1);
namespace Proner\PhpPimaco\Tags;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\ImageData\LogoImageData;
use Endroid\QrCode\Label\Font\Font;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QrCode
{
    private $size;
    private $label;
    private $labelFontSize;
    private $padding;
    private $margin;
    private $align;
    private $content;
    private $br;

    /**
     * QrCode constructor.
     * @param string $content
     * @param string|null $typeCode
     */
    public function __construct(string $content)
    {
        $this->content = $content;
        $this->labelFontSize = 12;
        $this->size = 100;
        $this->padding = 0;
        $this->align = 'left';
        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param int $labelFontSize
     * @return $this
     */
    public function setLabelFontSize(int $labelFontSize)
    {
        $this->labelFontSize = $labelFontSize;
        return $this;
    }

    /**
     * @param float $padding
     * @return $this
     */
    public function setPadding(float $padding)
    {
        $this->padding = $padding;
        return $this;
    }

    /**
     * @param int $margin
     * @return $this
     */
    public function setMargin($margin)
    {
        // if (is_array($margin)) {
        //     $margin = implode("mm ", $margin).'mm';
        // } else {
        //     $margin = $margin."mm";
        // }
        $this->margin = $margin;
        return $this;
    }

    /**
     * @param string $align
     * @return $this
     */
    public function setAlign(string $align)
    {
        $this->align = $align;
        return $this;
    }

    public function br()
    {
        $this->br .= "<br>";
    }

    /**
     * @return string
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public function render()
    {
        $builder = Builder::create();
        $builder->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->content)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->foregroundColor(new Color(0, 0, 0))
            ->backgroundColor(new Color(255, 255, 255))
        ;
        
        if ($this->margin !== null) {
            $builder->margin($this->margin);
        }

        if (!empty($this->size)) {
            $builder->size($this->size);
        }

        if (!empty($this->label)) {
            $builder->labelText($this->label);
        }

        $result = $builder->build();

        if ($this->br === null) {
            if ($this->align == 'left') {
                $styles[] = "float: left";
            } else {
                $styles[] = "float: right";
            }
        }

        $style = "";
        if (!empty($styles)) {
            $style = "style='".implode(";", $styles)."'";
        }

        return "<img ".$style." src='{$result->getDataUri()}'>".$this->br;
    }
}
