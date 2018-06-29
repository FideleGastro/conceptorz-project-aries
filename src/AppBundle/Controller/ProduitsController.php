<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 22:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Produits;
use AppBundle\Form\ProduitsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class poissonnerieController
 * @package AppBundle\Controller
 * @Route("produits")
 */
class ProduitsController extends Controller
{

    /**
     * @Route("/create", name="produit_create")
     * @Route("/update/{id}", name="produit_update")
     *
     */
    public function produitsCreateUpdateAction(Request $request, Produits $id = null){
        $form = $this->createForm(ProduitsType::class, $id);
        $form->remove('created_at')->remove('updated_at');

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $requestForm = $request->request->get($form->getName());

            $produitService = $this->get('produitsService');
            $produitService->createOrUpdate($form->getData());

            $produitService->relationsProduitsManager((!empty($requestForm['fournisseur'])) ? $requestForm['fournisseur'] : array());

            return $this->redirectToRoute('homepage');

        }

        return $this->render('@App/Produits/CreateUpdate.html.twig', array(
            'form' => $form->createView(),
            'product' => $id,
            )
        );
    }

    /**
     * @Route("/delete/{id}", name="produit_delete")
     */
    public function produitsDeleteAction(Produits $id){

        $produitService = $this->get('produitsService');
        $produitService->delete($id);

        return $this->redirectToRoute('homepage');

    }

}