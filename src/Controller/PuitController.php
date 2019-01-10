<?php

namespace App\Controller;

use App\Entity\Puit;
use App\Entity\PuitSearch;
use App\Form\PuitType;
use App\Form\PuitSearchType;
use App\Service\CheckConnectedUser;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/puits")
 **/
class PuitController extends AbstractController
{
  /**
   * @Route("/", name="puits")
   * @Security("has_role('ROLE_ADMIN')")
   **/
  public function index(Request $request, CheckConnectedUser $checker, ObjectManager $manager, PaginatorInterface $paginator)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $search = new PuitSearch();
    $form = $this->createForm(PuitSearchType::class, $search);
    $form->handleRequest($request);
    $repoPuit = $manager->getRepository(Puit::class);
    $puits = $paginator->paginate(
      $repoPuit->myFindAllQuery($search),
      $request->query->getInt('page', 1),
      20
    );
    return $this->render('Puit/index.html.twig', [
      'puits'   => $puits,
      'current' => 'puit',
      'form'    => $form->createView()
    ]);
  }

  /**
   * @Route("/ajouter-puit", name="add.puit")
   * @Security("has_role('ROLE_ADMIN')")
   **/
  public function add_puit(Request $request, CheckConnectedUser $checker, ObjectManager $manager)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');


    $puit = new Puit();
    $form = $this->createForm(PuitType::class, $puit);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
      $manager->persist($puit);
      $manager->flush();
      $this->addFlash('success', 'Le puit a été bien enregistré.');
      return $this->redirectToRoute('puits');
    }
    return $this->render('Puit/puit-add.html.twig', [
      'form' => $form->createView(),
      'current' => 'puit'
    ]);
  }

  /**
   * @Route("/editer-puit/{id}", name="edit.puit")
   * @Security("has_role('ROLE_ADMIN')")
   * @param Puit $puit
   **/
  public function edit_puit(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Puit $puit)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $form = $this->createForm(PuitType::class, $puit);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
      $puit->setUpdatedAt(new \DateTime());
      $manager->persist($puit);
      $manager->flush();
      $this->addFlash('success', 'Mise à jour réussie.');
      return $this->redirectToRoute('puits');
    }
    return $this->render('Puit/puit-edit.html.twig', [
      'form' => $form->createView(),
      'puit' => $puit,
      'current' => 'puit'
    ]);
  }

  /**
   * @Route("/informations-puit/{id}", name="informations.puit")
   * @Security("has_role('ROLE_ADMIN')")
   * @param Puit $puit
   **/
  public function informations_puit(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Puit $puit)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    return $this->render('Puit/puit-informations.html.twig', [
      'puit' => $puit,
      'current' => 'puit'
    ]);
  }
}

?>
