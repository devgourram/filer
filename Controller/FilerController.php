<?php
/**
 * Created by PhpStorm.
 * User: elfassihicham
 * Date: 03/06/2015
 * Time: 15:35
 */

namespace Iad\Bundle\FilerTechBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iad\Bundle\FilerTechBundle\Business\Exception\DocumentNotFoundException;
use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Entity\AdministrativeDocument;
use Iad\Bundle\FilerTechBundle\Entity\Avatar;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Exception\FilerException;

/**
 * Class FilerController
 * @package Iad\Bundle\FilerTechBundle\Controller
 */
class FilerController extends FOSRestController
{
    /**
     * Get document
     *
     * @deprecated
     * @param integer $uuid
     * @param string  $disposition
     *
     * @return Response
     */
    public function getDocumentAction($uuid, $disposition = 'inline')
    {
        /** @var DocumentObject $document */
        $document = $this->get('iad_filer.manager.document_object')->findOneByUuid($uuid);
        $file = $this->get('iad_filer.administrative_document_filer')->getFileFromEntity($document);

        $response = new Response($file->getContent(), 200, [
            'content-type'        => $file->getMimeType(),
            'content-disposition' => $disposition.'; filename="'.$file->getName().'"',
        ]);

        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * Get document
     *
     * @deprecated
     * @param integer $uuid
     *
     * @return Response
     */
    public function getDocumentDataAction($uuid)
    {
        try {
            /** @var DocumentObject $document */
            $document = $this->get('iad_filer.manager.document_object')->findOneByUuid($uuid);
        } catch (DocumentNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $response = $this->createJsonResponse($document->getDetails(), ['metadata']);
        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * Get document
     *
     * @deprecated
     * @param integer $uuid
     *
     * @return Response
     */
    public function getDocumentObjectAction($uuid)
    {
        try {
            /** @var DocumentObject $document */
            $document = $this->get('iad_filer.manager.document_object')->findOneByUuid($uuid);
            $file = $this->get('iad_filer.administrative_document_filer')->getFileFromEntity($document);
        } catch (DocumentNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $response = $this->createJsonResponse($document, ['metadata', 'content']);
        $response->setMaxAge(3600);

        return $response;
    }

    /**
     * Upload new Avatar.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @ApiDoc(
     *   resource=false,
     *   section="Filer",
     *   statusCodes={
     *     200="Response ok",
     *     404="Reference not found"
     *   }
     * )
     *
     * @View(serializerGroups={"Default"})
     *
     * @RequestParam(name="avatar", description="Avatar file", strict=true, nullable=true)
     * @RequestParam(name="x", description="The start x-coordinate of crop file", strict=true, nullable=true)
     * @RequestParam(name="y", description="The start y-coordinate of crop file", strict=true, nullable=true)
     * @RequestParam(name="width", description="width of crop file", strict=true, nullable=true)
     * @RequestParam(name="height", description="height of crop file", strict=true, nullable=true)
     *
     *@return \FOS\RestBundle\View\View
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @throws \Exception
     */
    public function uploadAvatarAction(Request $request, ParamFetcher $paramFetcher)
    {
        $user = $this->getUser();

        $message = 'avatar save successful';
        $code = Codes::HTTP_OK;

        try {
            $data = $paramFetcher->all();

            $originalFile = $request->files->get('avatar');

            if (!$originalFile || !$originalFile->isValid()) {
                throw new FilerException('Invalid avatar.', Codes::HTTP_BAD_REQUEST);
            }

            /**
             * @var AvatarFiler $serviceFiler
             */
            $serviceFiler = $this->get('iad_filer.avatar_filer');

            $cropParams = null;

            if ($data['x'] >= 0 && $data['y'] >= 0 && $data['width'] > 1 && $data['height'] > 1) {
                $cropParams = new CropParameters();

                $cropParams
                    ->setSize($data['width'], $data['height'])
                    ->setStart($data['x'], $data['y']);
            }

            $avatar = new Avatar();
            $avatar->setOriginalFile($originalFile);
            $avatar = $serviceFiler->create($avatar, $this->getUser()->getIdPeople(), [], $cropParams);

            $em = $serviceFiler->getAvatarManager();
            $em->persist($avatar);
            $user->addAvatar($avatar);

            $em->flush();
        } catch (FilerException $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
        } catch (\Exception $e) {
            $this->get('logger')->error($e->getMessage());
            $message = 'internal server error';
            $code = Codes::HTTP_BAD_REQUEST;
        }

        $view = $this->view(['message' => $message , 'code' => $code], $code);

        return $view;
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
