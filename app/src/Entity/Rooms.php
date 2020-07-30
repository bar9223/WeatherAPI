<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rooms
 *
 * @ORM\Table(name="rooms")
 * @ORM\Entity
 */
class Rooms
{
    /**
     * @var int
     *
     * @ORM\Column(name="room_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rooms_room_id_seq", allocationSize=1, initialValue=1)
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
