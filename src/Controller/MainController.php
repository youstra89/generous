<?php

namespace App\Controller;

use App\Service\CheckConnectedUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
  /**
   * @Route("/", name="homepage")
   **/
  public function index(CheckConnectedUser $checker)
  {
    if($checker->getAccess() == true)
      return $this->redirectToRoute('login');

    $user = $this->getUser();
    if($user->getDonnateur() === true)
      return $this->redirectToRoute('homepage.donnateur');

    return $this->render('base.html.twig', [
      'current' => 'accueil'
    ]);
  }
}

?>
