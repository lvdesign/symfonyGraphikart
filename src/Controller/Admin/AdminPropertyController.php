<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * Voir tous les Biens toto toto
     * 
     * @Route("/admin", name="admin.property.index")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }



    /**
     * Creer un Bien
     * 
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $property = new Property();

        $form= $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien creer avec succes!');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
    

    /**
    *  Update un Bien
    *
    * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
    * @param Property $property
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function edit(Property $property, Request $request)
    {
       // image control cache
    //    if($property->getImageFile() instanceof UploadedFile){
    //     $cachemanager->remove($helper->asset($property,'imageFile'));
    //    }
        // ajout TAGs
        // $option = new Option();
        // $property->addOption($option);
       
        $form= $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {            
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès!');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     *  Delete un bien
     * 
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request){

        if( $this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush(); 
            $this->addFlash('success', 'Bien supprimé avec succes!');
        }     
        return $this->redirectToRoute('admin.property.index');
    }


}
