<?php

namespace  App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository 
     */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository; 
        // Injection de dependance par AbstractController
        // cette technique car plusieurs ensuite
        $this->em =$em;
    }


    /**
     * INDEX
     * 
     * lienUrl, nomClassFunction
     * @Route("/biens", name="property.index" )
     * @return Response
     */

    public function index(PaginatorInterface $paginator, Request $request ): Response
    {
        // SEARCH --- Ceer un champ de recherche
        // creer une Entite representant la recherche : 
        // creer un Formulaire
        // gerer le traitement ds le controlleur 

        $search  = new PropertySearch();
        $form = $this->createForm( PropertySearchType::class, $search);
        $form->handleRequest($request);

      
        // Pagination
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        // 12 articles par page
        
        );
        // dump($properties);


        return $this->render( 'property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }


    
    /**
     * SHOW
     * 
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    //public function show($slug, $id): Response
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
    {
        
        // pour être sur de bien attraper le slug
        if( $property->getSlug() !== $slug ){
            return $this->redirectToRoute('property.show',[
                'id' =>$property->getId(),
                'slug' =>$property->getSlug()
            ], 301);
        }

        // Mail Contact action
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message est envoyé.');
           
            /* return $this->redirectToRoute('property.show',[
                'id' =>$property->getId(),
                'slug' =>$property->getSlug()
            ]); */
           
        }

        
        return $this->render( 'property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()
            ]);
    }

}


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
        //$properties = $this->repository->findAllVisible();