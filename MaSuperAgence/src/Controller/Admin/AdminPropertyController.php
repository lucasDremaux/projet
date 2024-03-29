<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Form\AgenceType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties =$this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'sauvegarde de votre bien');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', ['property' => $property, 'form' => $form->createView()]);
    }

    /**
     * @Route("admin/property/edit/{id}", name="admin.property.edit")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    public function edit (Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'modifications sauvegardés');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', ['property' => $property, 'form' => $form->createView()]);
    }

    /**
     * @Route("admin/property/delete/{id}", name="admin.property.delete")
     * @param Property $property
     * @return \Symfony\Component\HttpFoudattion\RedirectResponse
     */

    public function delete(Property $property, Request $request)
    {    
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'suppression de votre bien');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}
