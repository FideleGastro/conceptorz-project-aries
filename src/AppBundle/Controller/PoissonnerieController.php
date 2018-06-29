<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 22:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Fournisseurs;
use AppBundle\Entity\Produits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PoissonnerieController extends Controller
{

    /**
     * @Route("/", name="homepage")
     *
     */
    public function homepageAction(){

        return $this->render('@App/Default/index.html.twig', array(
            'fournisseurs' => $this->getDoctrine()->getRepository(Fournisseurs::class)->findAll(),
            'produits' => $this->getDoctrine()->getRepository(Produits::class)->findAll()
            )
        );
    }

}