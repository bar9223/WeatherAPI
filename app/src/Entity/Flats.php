<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Flats
 *
 * @ORM\Table(name="flats")
 * @ORM\Entity
 */
class Flats
{
    /**
     * @var int
     *
     * @ORM\Column(name="fl_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flats_fl_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="fl_beds_nr", type="integer", length=16, nullable=true)
     */
    protected $bedsNr;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="fl_price", type="integer", length=16, nullable=true)
     */
    protected $price;

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

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }
}
