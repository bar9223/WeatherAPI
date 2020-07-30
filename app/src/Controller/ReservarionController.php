<?php
namespace App\Controller;


use App\Entity\Reservations;
use App\EntityManagers\MainEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReservarionController extends AbstractController
{
    protected $em;
    public function __construct(MainEntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $reservation = $this->em->getRepository(Reservations::class)->findBy([
            'id' => 1
        ]);
        var_dump($reservation);
        return $this->render('index.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}