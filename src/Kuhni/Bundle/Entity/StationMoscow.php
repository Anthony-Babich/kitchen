<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StationMoscow
 *
 * @ORM\Table(name="station_moscow")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\StationMoscowRepository")
 */
class StationMoscow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name_station", type="string", length=255)
     */
    private $nameStation;

    /**
     * @var string
     *
     * @ORM\Column(name="line", type="string", length=255)
     */
    private $line;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNameStation()
    {
        return $this->nameStation;
    }

    /**
     * @param string $nameStation
     * @return StationMoscow
     */
    public function setNameStation(string $nameStation)
    {
        $this->nameStation = $nameStation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $line
     * @return StationMoscow
     */
    public function setLine(string $line)
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return StationMoscow
     */
    public function setColor(string $color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}