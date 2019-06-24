<?php

namespace  App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository 
     */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository; // cette technique car plusieurs ensuite
        $this->em =$em;
    }


    /**
     * @Route("/biens", name="property.index" )
     * @return Response
     */

    public function index(): Response
    {
        // CRRER le demarage ds BD
        // $property = new  Property();
        // $property->setTitle('Mon premier titre')
        //             ->setPrice(200000)
        //             ->setRooms(4)
        //             ->setBedrooms(3)
        //             ->setDescription(' test desc')
        //             ->setSurface(60)
        //             ->setFloor(2)
        //             ->setHeat(1)
        //             ->setCity('Paris')
        //             ->setAddress('1 rue de la paix')
        //             ->setPostalCode('75001');
                    
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush();

        //$property = $this->repository->findAllVisible();
        //dump($property);
        //$property[0]->setSold(true);
        
        return $this->render( 'property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    //public function show($slug, $id): Response
    public function show(Property $property, string $slug): Response
    {
        // pour être sur de bien attraper le slug
        if( $property->getSlug() !== $slug ){
            return $this->redirectToRoute('property.show',[
                'id' =>$property->getId(),
                'slug' =>$property->getSlug()
            ], 301);

        }
        
        return $this->render( 'property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
            ]);
    }

}