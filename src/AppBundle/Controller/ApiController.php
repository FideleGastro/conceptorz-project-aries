<?php
/**
 * Created by PhpStorm.
 * User: Aries
 * Date: 26/06/2018
 * Time: 14:38
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Produits;
use FOS\RestBundle\Context\Context;
//use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends FOSRestController
{

    /**
     * @Get("/test/")
     */

    public function getApiAction(Request $request){
        $data = array();
        foreach ($this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll() as $item){
            $data[$item->getId()] = $item->getNom();
        }
        //dump($request->headers->all());
        ///die();
        //$serialize= $this->get('fos_rest.serializer');
        //return new Response($serialize->serialize($data, 'json', new Context()));
        return new JsonResponse($data, 201);
    }
}