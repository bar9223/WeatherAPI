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
     * @ORM\Column(name="res_date_from", type="datetime", nullable=true)
     */
    protected $dateFrom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="res_date_to", type="datetime", nullable=true)
     */
    protected $dateTo;

    /**
     * @var Flats
     *
     * @ORM\ManyToOne(targetEntity="Flats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="res_flat", referencedColumnName="fl_id")
     * })
     */
    protected $flats;

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
    public function getDateFrom(): ?\DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime|null $dateFrom
     */
    public function setDateFrom(?\DateTime $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateTo(): ?\DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime|null $dateTo
     */
    public function setDateTo(?\DateTime $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return Flats
     */
    public function getFlats(): Flats
    {
        return $this->flats;
    }

    /**
     * @param Flats $flats
     */
    public function setFlats(Flats $flats): void
    {
        $this->flats = $flats;
    }
}
