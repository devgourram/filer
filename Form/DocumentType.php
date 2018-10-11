<?php

namespace Iad\Bundle\FilerTechBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    /**
     * Allowed mime types
     */
    const MIME_TYPES = ["application/pdf", "application/x-pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "image/jpeg", "image/png"];

    /**
     * Allowed max size : 15 megabyte
     */
    const MAX_SIZE = 15000000;


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($options);
        $builder
            ->add('originalFile', FileType::class, [
                'required' => true,
                'label' => 'iad_filer.form.document_file.label',
                'attr' => [
                    'accept' => implode(",", self::MIME_TYPES),
                    'data-max-size' => self::MAX_SIZE,
                    'class' => 'check-size',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iadfilertech_document';
    }



    

}
