<?php

namespace App\Controller;

use App\Entity\Mosquee;
use App\Entity\MosqueeSearch;
use App\Form\MosqueeType;
use App\Form\MosqueeSearchType;
use App\Service\CheckConnectedUser;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/mosquees")
 **/
class MosqueeController extends AbstractController
{
  /**
   * @Route("/", name="mosquees")
   * @Security("has_role('ROLE_ADMIN')")
   **/
  public function index(Request $request, CheckConnectedUser $checker, ObjectManager $manager, PaginatorInterface $paginator)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $search = new MosqueeSearch();
    $form = $this->createForm(MosqueeSearchType::class, $search);
    $form->handleRequest($request);
    $repoMosquee = $manager->getRepository(Mosquee::class);
    $mosquees = $paginator->paginate(
      $repoMosquee->myFindAllQuery($search),
      $request->query->getInt('page', 1),
      20
    );
    return $this->render('Mosquee/index.html.twig', [
      'mosquees' => $mosquees,
      'current'  => 'mosquee',
      'form'     => $form->createView()
    ]);
  }

  /**
   * @Route("/ajouter-mosquee", name="add.mosquee")
   * @Security("has_role('ROLE_ADMIN')")
   **/
  public function add_mosquee(Request $request, CheckConnectedUser $checker, ObjectManager $manager)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');


    $mosquee = new Mosquee();
    $form = $this->createForm(MosqueeType::class, $mosquee);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
      $manager->persist($mosquee);
      $manager->flush();
      $this->addFlash('success', 'La mosquée a été bien enregistrée.');
      return $this->redirectToRoute('mosquees');
    }
    return $this->render('Mosquee/mosquee-add.html.twig', [
      'form' => $form->createView(),
      'current' => 'mosquee'
    ]);
  }

  /**
   * @Route("/editer-mosquee/{id}", name="edit.mosquee")
   * @Security("has_role('ROLE_ADMIN')")
   * @param Mosquee $mosquee
   **/
  public function edit_mosquee(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Mosquee $mosquee)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $form = $this->createForm(MosqueeType::class, $mosquee);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
      $mosquee->setUpdatedAt(new \DateTime());
      $manager->persist($mosquee);
      $manager->flush();
      $this->addFlash('success', 'Mise à jour réussie.');
      return $this->redirectToRoute('mosquees');
    }
    return $this->render('Mosquee/mosquee-edit.html.twig', [
      'form' => $form->createView(),
      'mosquee' => $mosquee,
      'current' => 'mosquee'
    ]);
  }

  /**
   * @Route("/informations-mosquee/{id}", name="informations.mosquee")
   * @Security("has_role('ROLE_ADMIN')")
   * @param Mosquee $mosquee
   **/
  public function informations_mosquee(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Mosquee $mosquee)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    return $this->render('Mosquee/mosquee-informations.html.twig', [
      'mosquee' => $mosquee,
      'current' => 'mosquee'
    ]);
  }
}

?>
