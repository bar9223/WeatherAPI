<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherStorage
 *
 * @ORM\Table(name="weather_storage")
 * @ORM\Entity
 */
class WeatherStorage
{
    /**
     * @var int
     *
     * @ORM\Column(name="ws_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_city", type="string", length=64, nullable=false, options={"fixed"=true})
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_temperature", type="text", nullable=true)
     */
    private $temp;

    /**
     * @var int
     *
     * @ORM\Column(name="ws_timestamp", type="integer", nullable=false)
     */
    private $timestamp;

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
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getTemp(): string
    {
        return $this->temp;
    }

    /**
     * @param string $temp
     */
    public function setTemp(string $temp): void
    {
        $this->temp = $temp;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}

