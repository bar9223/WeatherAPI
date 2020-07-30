<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity
 */
class Rooms
{
    /**
     * @var int
     *
     * @ORM\Column(name="res_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="res_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="room_beds_nr", type="integer", length=16, nullable=true)
     */
    private $bedsNr;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getBedsNr(): ?int
    {
        return $this->bedsNr;
    }

    /**
     * @param int|null $bedsNr
     */
    public function setBedsNr(?int $bedsNr): void
    {
        $this->bedsNr = $bedsNr;
    }


}
