<?php

namespace App\Controller;

use App\Entity\Line;
use App\Entity\Node;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class HomeController extends AbstractController
{
  /**
   * @var EntityManagerInterface $em
  */
    public function __construct(
     private EntityManagerInterface $em
    ){
      }

    #[Route('/', name: 'app_home')]
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data = [];
        // Get lines data from database
        $lines = $this->em->getRepository(Line::class)->findAll();

        //Test filter option
         if($request->query->get('ajax') ){

             $lineName = $request->query->get('p');

             //get filtered data
             $data = $this->em->getRepository(Node::class)->findFiltredData($lineName);

             return new JsonResponse([
                 'content' =>  $this->renderView('home/table.html.twig', [
                     'data' => $data,

                 ])
             ]);


         }else{
             //Get default data (all data)
             $data = $this->em->getRepository(Node::class)->findAll();

         }

        return $this->render('home/index.html.twig', [
            'data' => $data,
            'lines'=> $lines
        ]);
    }
}
