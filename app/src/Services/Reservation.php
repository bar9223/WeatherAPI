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
    protected $discount = 15;

    public function __construct(MainEntityManager $em)
    {
        $this->em = $em;
    }

    public function filterGet() : ?bool
    {
        $flag = false;
        if ($_GET) {
            $dateRegex = [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^\d{4}(\-)(((0)[0-9])|((1)[0-2]))(\-)([0-2][0-9]|(3)[0-1])$/"]
            ];
            $filteredGet = filter_input_array(INPUT_GET, [
                'people' => FILTER_VALIDATE_INT,
                'dateFrom' => $dateRegex,
                'dateTo' => $dateRegex,
            ]);
            if ($filteredGet['people'] && $filteredGet['dateFrom'] && $filteredGet['dateTo']) {
                $this->setPeople($filteredGet['people']);
                $this->setDateFrom($filteredGet['dateFrom']);
                $this->setDateTo($filteredGet['dateTo']);
                $flag = true;
            }
        }

        return $flag;
    }

    public function calculateDiscount() : ?float
    {
        if ($this->discount) {
            $actualDisc = (100 - $this->discount)/100;

            return $actualDisc;
        }

        return 1;
    }

    public function setReservation()
    {
        /**
         * @var Flats $flat
         */
        $flat = $this->em->getRepository(Flats::class)->findOneBy([
            'id' => 1,
        ]);
        $reservation = new Reservations();
        $reservation->setPeople($this->people);
        $reservation->setDatetimeFrom(new \DateTime($this->dateFrom));
        $reservation->setDatetimeTo(new \DateTime($this->dateTo));
        $reservation->setFlat($flat);
        $this->em->persist($reservation);
        $this->em->flush();
    }

    public function reservateHostel()
    {
        if ($this->filterGet()) {
            $busy = false;
            $info ='';
            $datesArray = $this->getDatePeriod();
            $days = $this->numOfDays();
            foreach($datesArray as $date) {
                $peopleNumber = 0;
                $qb = $this->em->getRepository(Reservations::class)->createQueryBuilder('res')->select(
                    [
                        'res.people',
                        'fl.id',
                        'fl.bedsNr',
                        'fl.price'
                    ]
                );
                $qb->innerJoin(Flats::class, 'fl', 'WITH', 'res.flat = fl.id');
                $qb->where(':date BETWEEN res.datetimeFrom AND res.datetimeTo')
                    ->setParameter('date', new \DateTime($date));
                $query = $qb->getQuery();
                $list = $query->getResult();
                if (!empty($list)) {
                    foreach ($list as $key => $value) {
                        $peopleNumber += $list[$key]['people'];
                        $price = (float)$list[$key]['price']/100;
                        $bedsNr = $list[$key]['bedsNr'];
                    }
                    if ($peopleNumber + $this->people > $bedsNr)  {
                        $busy = true;
                        break;
                    }

                } else {
                    /**
                     * @var Flats $flat
                     */
                    $flat = $this->em->getRepository(Flats::class)->findAll();
                    $price = $flat[0]->getPrice()/100;
                }
            }
            if (!$busy) {
                $this->setReservation();
                $info = 'Rezerwacja została przyjęta dla '.$this->people.' osób w terminie między '.$this->dateFrom.' i '. $this->dateTo.'. ';

                if($days >= 7) {
                    $info .= 'Państwa pobyt będzie trwał ponad tydzień, dlatego przyznajemy '. $this->discount.'% rabatu na całkowity koszt pobytu! ';
                    $info .= 'Łączny koszt pobytu to: '. ($days * $price) * $this->calculateDiscount().'zł';
                } else {
                    $info .= 'Łączny koszt pobytu to: '. $days * $price .'zł';
                }

                return $info;
            } else {
                $info = 'Niestety w wybranym terminie nasz hostel jest zajęty. Prosimy sprawdzić inny termin';
                return $info;
            }
        } else {
            $info = 'Podane dane są nieprawidłowe, prosimy podać wymagane informacje';
            return $info;
        }
    }

    public function checkFlatStatus()
    {

    }

    public function numOfDays() : int
    {
        $dateFrom = new \DateTime($this->dateFrom);
        $dateTo = new \DateTime($this->dateTo);
        $interval = $dateFrom->diff($dateTo);
        $days = $interval->days;

        return $days;
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

    public function getDatePeriod()
    {
        $datesArray = [];
        $date_from = strtotime($this->dateFrom); // Convert date to a UNIX timestamp
        $date_to = strtotime($this->dateTo); // Convert date to a UNIX timestamp

        for ($i=$date_from; $i<=$date_to; $i+=86400) {
            $datesArray[] =  date("Y-m-d", $i);
        }

        return $datesArray;
    }
}