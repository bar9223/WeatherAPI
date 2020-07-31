<?php
namespace App\Controller;


use App\Entity\Reservations;
use App\EntityManagers\MainEntityManager;
use App\Services\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReservarionController extends AbstractController
{
    protected $em;
    protected $reservationService;

    public function __construct(
        MainEntityManager $em,
        Reservation $reservationService
    ) {
        $this->em = $em;
        $this->reservationService = $reservationService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {

        $result = $this->reservationService->reservateHostel();
        return $this->render('index.html.twig', [
            'result' => $result,
        ]);
    }
}