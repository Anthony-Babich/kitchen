<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\SettingsRepository")
 */
class Settings
{
    use TraitId;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="setting", type="string", length=3000)
     */
    private $setting;

    /**
     * Set name
     *
     * @param float $name
     *
     * @return Settings
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set setting
     *
     * @param float $setting
     *
     * @return Settings
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;

        return $this;
    }

    /**
     * Get setting
     *
     * @return float
     */
    public function getSetting()
    {
        return $this->setting;
    }
}