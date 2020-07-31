<?php


namespace App\Services;


use App\Entity\Flats;
use App\Entity\Reservations;
use App\EntityManagers\MainEntityManager;

class Reservation
{
    protected $filteredGet;
    protected $em;
    protected $people;
    protected $dateFrom;
    protected $dateTo;

    public function __construct(MainEntityManager $em)
    {
        $this->em = $em;
    }

    public function filterGet() : void
    {
        if ($_GET) {
            $dateRegex = [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$/"]
            ];
            $filteredGet = filter_input_array(INPUT_GET, [
                'people' => FILTER_VALIDATE_INT,
                'dateFrom' => $dateRegex,
                'dateTo' => $dateRegex,
            ]);

            if ($filteredGet['people'] && $filteredGet['dataFrom'] && $filteredGet['dataTo']) {
                $this->setPeople($filteredGet['people']);
                $this->setDateFrom($filteredGet['dataFrom']);
                $this->setDateTo($filteredGet['dateTo']);
            }
        }
    }

    public function setReservation()
    {
        $reservation = new Reservations();
        $reservation->setPeople($this->people);
        $reservation->setDatetimeFrom($this->dateFrom);
        $reservation->setDatetimeTo($this->dateTo);
        /**
         * TODO save reservation with specified flat
         */
    }

    public function reservateHostel()
    {

        /**
         * TODO correct query and validate if selected date is free for rent
         */
        if (isset($this->filteredGet)) {
            $qb = $this->em->getRepository(Reservations::class)->createQueryBuilder('res')->select('COUNT');
            $qb->innerJoin(Flats::class, 'fl', 'WITH', 'res.flat = fl.id');
            $qb->where('res.dateFrom BETWEEN :firstDate AND :lastDate')
                ->setParameter('dateFrom', $this->dateFrom)
                ->setParameter('dateTo', $this->dateTo);
            $query = $qb->getQuery();

            $this->list = $query->getResult();
        }
    }

    private function setPeople($people)
    {
        $this->people = $people;
    }

    private function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    private function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }

}