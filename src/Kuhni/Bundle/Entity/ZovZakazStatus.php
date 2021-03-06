<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZovZakazStatus
 *
 * @ORM\Table(name="zov_zakaz_status")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\ZovZakazStatusRepository")
 */
class ZovZakazStatus
{
    use TraitId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, unique=true)
     */
    private $status;

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ZovZakazStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}