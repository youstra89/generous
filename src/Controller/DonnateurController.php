<?php

namespace App\Controller;

use App\Entity\Puit;
use App\Entity\Mosquee;
use App\Service\CheckConnectedUser;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class DonnateurController extends AbstractController
{
  /**
   * @Route("/index", name="homepage.donnateur")
   **/
  public function index(CheckConnectedUser $checker)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $user = $this->getUser();
    return $this->render('base-donnateur.html.twig', [
      'current' => 'accueil'
    ]);
  }

  /**
   * @Route("/user-mosquee", name="user.mosquees")
   * @Security("has_role('ROLE_USER')")
   **/
  public function mosquee(Request $request, CheckConnectedUser $checker, ObjectManager $manager, PaginatorInterface $paginator)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $userId = $this->getUser()->getId();
    $repoMosquee = $manager->getRepository(Mosquee::class);
    $mosquees = $paginator->paginate(
      $repoMosquee->userMosquees($userId),
      $request->query->getInt('page', 1),
      20
    );
    return $this->render('Don/mosquee.html.twig', [
      'mosquees' => $mosquees,
      'current'  => 'mosquee',
    ]);
  }

  /**
   * @Route("/informations-user-mosquee/{id}", name="informations.user.mosquee")
   * @Security("has_role('ROLE_USER')")
   * @param Mosquee $mosquee
   **/
  public function informations_mosquee(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Mosquee $mosquee)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    return $this->render('Don/mosquee-informations.html.twig', [
      'mosquee' => $mosquee,
      'current' => 'mosquee'
    ]);
  }

  /**
   * @Route("/user-puit", name="user.puits")
   * @Security("has_role('ROLE_USER')")
   **/
  public function puit(Request $request, CheckConnectedUser $checker, ObjectManager $manager, PaginatorInterface $paginator)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $userId = $this->getUser()->getId();
    $repoPuit = $manager->getRepository(Puit::class);
    $puits = $paginator->paginate(
      $repoPuit->userPuits($userId),
      $request->query->getInt('page', 1),
      20
    );
    return $this->render('Don/puit.html.twig', [
      'puits' => $puits,
      'current'  => 'puit',
    ]);
  }

  /**
   * @Route("/informations-user-puit/{id}", name="informations.user.puit")
   * @Security("has_role('ROLE_USER')")
   * @param Puit $puit
   **/
  public function informations_puit(Request $request, CheckConnectedUser $checker, ObjectManager $manager, Puit $puit)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    return $this->render('Don/mosquee-informations.html.twig', [
      'puit' => $puit,
      'current' => 'puit'
    ]);
  }
}

?>
