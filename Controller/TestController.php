<?php

namespace Iad\Bundle\FilerTechBundle\Controller;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TestController
 * @package Iad\Bundle\FilerTechBundle\Controller
 */
class TestController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function postDocumentAction(Request $request)
    {
        $kernel = $this->get('kernel');

        if (!in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            throw new \Exception('Test controller forbidden in production');
        }

        /**
         * @var \Iad\Bundle\FilerTechBundle\Business\Filer $filer
         * @var \Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder $fileBuilder
         */
        $filer = $this->get('iad_filer');
        $fileBuilder = $this->get('iad_filer.builder');

        $form = $this->buildForm(
            DocumentObject::getAllAccess(),
            $filer->getDocumentTypes()
        );

        $responseFiler = null;
        $metadata = null;
        $errors = [];

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $fileUpload = $form['file']->getData();
                $access = $form['access']->getData();
                $type = $form['type']->getData();

                $file = $fileBuilder->getFromFileUpload(
                    $fileUpload,
                    $type,
                    $access
                );

                try {
                    $responseFiler = $filer->save($file);
                    $metadata = $filer->getMetaData($responseFiler['uuid']);
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage().' ('.get_class($e).')';
                }
            }
        }

        $view = $this->renderView('IadFilerTechBundle:Test:document.html.twig', [
            'form'           => $form->createView(),
            'response_filer' => $responseFiler,
            'metadata'       => $metadata,
            'errors'         => $errors,
        ]);

        return new Response($view, 200, ['Content-type' => 'text/html']);
    }

    protected function buildForm(array $access, array $documentTypes)
    {
        $accessChoices = array_combine($access, $access);
        $typeChoices   = array_combine($documentTypes, $documentTypes);

        return $this
            ->createFormBuilder(null)
            ->add('file', 'file')
            ->add('access', 'choice', [
                'choices' => $accessChoices,
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('type', 'choice', [
                'choices' => $typeChoices,
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('Send', 'submit')
            ->getForm();
    }
}
