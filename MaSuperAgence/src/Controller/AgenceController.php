<?php

namespace App\Controller;
use App\Controller\Contact;
use App\Entity\Contact as EntityContact;
use App\Entity\Property;
use App\Form\AgenceType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;

class AgenceController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManadger
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em; 
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements ={"slug": "[a-z0-9\-]*"})
     * @return Property $property
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request):Response
    {
        if($property->getSlug() !== $slug)
        {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        $contact = new EntityContact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success', 'Votre mail à bien été envoyé');
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()]);
    }
}

?>