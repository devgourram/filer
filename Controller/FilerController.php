<?php
/**
 * Created by PhpStorm.
 * User: elfassihicham
 * Date: 03/06/2015
 * Time: 15:35
 */

namespace Iad\Bundle\FilerTechBundle\Controller;

use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentNotFoundException;
use Iad\Bundle\FilerTechBundle\Business\ResizeParameters;
use Iad\Bundle\FilerTechBundle\Form\Type\ResizeParametersType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

/**
 * Class FilerController
 * @package Iad\Bundle\FilerTechBundle\Controller
 */
class FilerController extends Controller
{
    /**
     * Get document
     *
     * @param integer $uuid
     * @param Request $request
     *
     * @return array
     */
    public function getDocumentAction($uuid, Request $request)
    {
        /**
         * @var \Iad\Bundle\FilerTechBundle\Business\Filer $filer
         */
        $filer = $this->get('iad_filer');
        $document = $filer->get($uuid);

        if ($filer->isImage($document)) {
            $params = new ResizeParameters();
            $form = $this->createForm(new ResizeParametersType(), $params, ['method' => 'GET']);

            $form->handleRequest($request);

            if ($form->isValid()) {
                $content = $filer->resize($document, $params);
            } else {
                $content = $document->getContent();
            }
        } else {
            $content = $document->getContent();
        }

        $response = new Response($content, 200, [
            'content-type'        => $document->getMimeType(),
            'content-disposition' => $params->getDisposition().'; filename="'.$document->getName().'"',
        ]);

        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * Get document
     *
     * @param integer $uuid
     *
     * @return array
     */
    public function getDocumentDataAction($uuid)
    {
        try {
            $content = $this->get('iad_filer')->getMetaData($uuid);
        } catch (DocumentNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $response = $this->createJsonResponse($content, ['metadata']);
        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * Get document
     *
     * @param integer $uuid
     *
     * @return array
     */
    public function getDocumentObjectAction($uuid)
    {
        try {
            $content = $this->get('iad_filer')->get($uuid);
        } catch (DocumentNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $response = $this->createJsonResponse($content, ['metadata', 'content']);
        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * @param mixed $content
     * @param array $groups
     * @return Response
     */
    protected function createJsonResponse($content, $groups = [])
    {
        return new Response(
            $this->get('serializer')->serialize($content, 'json', SerializationContext::create()->setGroups($groups)),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
