<?php

namespace Correios;

class Package
{

    private $format = 1;
    private $weight;
    private $length;
    private $height;
    private $width;
    private $diameter;


    /**
     * Formato da encomenda (incluindo embalagem) adicione um valor inteiro
     * @param int $format
     * @return $this
     */
    public function setFormat($format = 1)
    {
        $this->format = (int)$format;
        return $this;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Adicione medidas da embalagem altura, largura e comprimento
     * @param int $height
     * @param int $width
     * @param int $length
     * @return $this
     */
    public function setMediated($height = 2, $width = 11, $length = 16)
    {
        $this->height = ($height < 2) ? 2 : $height;
        $this->width = ($width < 11) ? 11 : $width;
        $this->length = ($length < 16) ? 16 : $length;

        $this->diameter = $this->height + $this->width;

        return $this;
    }

    /**
     * Adicona o peso da embalagem
     * @param $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = ($weight < 0.300) ? 0.300 : $weight;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getWeight()
    {
        return $this->weight;
    }



    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getDiameter()
    {
        return $this->diameter;
    }
}