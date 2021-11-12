<?php

namespace App\Controller\Admin;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/agence')]
class AdminAgenceController extends AbstractController
{
    #[Route('/', name: 'admin.agence.index', methods: ['GET'])]
    public function index(AgenceRepository $agenceRepository): Response
    {
        return $this->render('admin/agence/index.html.twig', [
            'agences' => $agenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin.agence.new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $agence = new Agence();
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agence);
            $entityManager->flush();

            return $this->redirectToRoute('admin.agence.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/agence/new.html.twig', [
            'agence' => $agence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin.agence.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agence $agence): Response
    {
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.agence.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/agence/edit.html.twig', [
            'agence' => $agence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin.agence.delete', methods: ['POST'])]
    public function delete(Request $request, Agence $agence): Response
    {
        if ($this->isCsrfTokenValid('admin/delete'.$agence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.agence.index', [], Response::HTTP_SEE_OTHER);
    }
}
