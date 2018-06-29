<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 22:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Fournisseurs;
use AppBundle\Form\FournisseursType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class poissonnerieController
 * @package AppBundle\Controller
 * @Route("fournisseurs")
 */
class FournisserusController extends Controller
{

    /**
     * @Route("/create", name="fournisseur_create")
     * @Route("/update/{id}", name="fournisseur_update")
     * @Method({"POST", "GET"})
     *
     */
    public function fournisseursCreateUpdateAction(Request $request, Fournisseurs $id = null){
        $form = $this->createForm(FournisseursType::class, $id);
        $form->remove('created_at')->remove('updated_at');

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $requestForm = $request->request->get($form->getName());

            $fournisseurService = $this->get('fournisseursService');
            $fournisseurService->createOrUpdate($form->getData());

            $fournisseurService->relationsManager((!empty($requestForm['produit'])) ? $requestForm['produit'] : array());

            return $this->redirectToRoute('homepage');

        }

        return $this->render('@App/Fournisseurs/CreateUpdate.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/delete/{id}", name="fournisseur_delete")
     */
    public function produitsDeleteAction(Fournisseurs $id){
        $fournisseurService = $this->get('fournisseursService');
        $fournisseurService->delete($id);

        return $this->redirectToRoute('homepage');
    }

}