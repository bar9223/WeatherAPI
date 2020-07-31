<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity
 */
class Reservations
{
    /**
     * @var int
     *
     * @ORM\Column(name="res_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reservations_res_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="res_people", type="integer", length=16, nullable=true)
     */
    protected $people;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="res_datetime_from", type="datetime", nullable=true)
     */
    protected $datetimeFrom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="res_datetime_to", type="datetime", nullable=true)
     */
    protected $datetimeTo;

    /**
     * @var Flats
     *
     * @ORM\ManyToOne(targetEntity="Flats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="res_flat", referencedColumnName="fl_id")
     * })
     */
    protected $flat;

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
    public function getPeople(): ?int
    {
        return $this->people;
    }

    /**
     * @param int|null $people
     */
    public function setPeople(?int $people): void
    {
        $this->people = $people;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatetimeFrom(): ?\DateTime
    {
        return $this->datetimeFrom;
    }

    /**
     * @param \DateTime|null $datetimeFrom
     */
    public function setDatetimeFrom(?\DateTime $datetimeFrom): void
    {
        $this->datetimeFrom = $datetimeFrom;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatetimeTo(): ?\DateTime
    {
        return $this->datetimeTo;
    }

    /**
     * @param \DateTime|null $datetimeTo
     */
    public function setDatetimeTo(?\DateTime $datetimeTo): void
    {
        $this->datetimeTo = $datetimeTo;
    }

    /**
     * @return Flats
     */
    public function getFlat(): Flats
    {
        return $this->flat;
    }

    /**
     * @param Flats $flat
     */
    public function setFlat(Flats $flat): void
    {
        $this->flat = $flat;
    }
}
