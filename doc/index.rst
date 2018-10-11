Configuration
=============

Installation
------------

Installation 6 step process:

1. Download IadFilerTechBundle using composer
2. Enable translation
3. Enable the Bundle
4. Configure the IadFilerTechBundle
5. Create your Picture class or Document
6. Update your database schema

Step 1: Download IadFilerTechBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Require the bundle with composer.

.. code-block:: bash

    $ composer require iad-holding/filer-tech-bundle "master"


Step 2: Enable translation
~~~~~~~~~~~~~~~~~~~~~~~~~~

enable translation support

.. code-block:: yaml

    # app/config/config.yml

    framework:
        translator: ~

Step 3: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~


Enable the bundle in the kernel.

    .. code-block:: php-annotations

        public function registerBundles()
        {
            $bundles = array(
                // ... Dépendances IadCoreBundle
                new \JMS\SerializerBundle\JMSSerializerBundle(),
                new \FOS\RestBundle\FOSRestBundle(),

                // ... Dépendances IadFilerTechBundle
                new \Liip\ImagineBundle\LiipImagineBundle(),
                new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
                new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

                new \Iad\Bundle\CoreBundle\IadCoreBundle(),
                new Iad\Bundle\FilerTechBundle\IadFilerTechBundle(),
                // ...
            );
        }


Step 5: Configure the IadFilerTechBundle
~~~~~~~~~~~~~~~~~~~~~~~~~

PictureFiler
~~~~~~~~~~~

Create parameters for  public & private path.

    .. code-block:: yaml

        parameters:
            filer_channel_local_public_path: path/public
            filer_channel_local_private_path: path/private
            picture_filer.base_url: public/url

Append the default configuration of the bundle

    .. code-block:: yaml

        #app/config/config.yml
        import:
            - { resource: "@IadFilerTechBundle/Resources/config/config.yml" }

Base configuration, note that the bundle expose 4 defaults resizing_filters ['small', 'medium', 'high', 'tiny'].

    .. code-block:: yaml

        # app/config/config.yml
        iad_filer_tech:
            picture_filer:
                channel: local
                public_base_url: "%picture_filer.base_url%"
                    entries:
                        entity_picture:
                            resizing_filters: ['small', 'tiny']
                            class_file: AppBundle\Entity\PictureFile
                            class: AppBundle\Entity\Picture
                            directory_prefix: 'iad_pictures/'
                            document_type: 'pic'


If you wish create your own filters, create filter under liip_imagine key inside before using it.

    .. code-block:: yaml

        # app/config/config.yml
        liip_imagine:
            filter_sets:
                filterName:
                    quality: 90
                    filters:
                        thumbnail: { size: [800, 600], mode: inset }




DocumentFiler
~~~~~~~~~~~~

    .. code-block:: yaml

        # app/config/config.yml
        iad_filer_tech:
            document_filer:
                channel: local
                entries:
                    entity_document:
                        class: AppBundle\Entity\Document
                        directory_prefix: 'iad_documents/'
                        document_type: 'doc'



Step 5: Create your Picture class or Document
~~~~~~~~~~~~~~~~~~~~~~~~~

Create Picture class that extend from the base class.

    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/Picture.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Entity\BasePicture as BasePicture;
        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="app_pictures")
         */
        class Picture extends BasePicture
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

        }

OR

For using Document instead of Picture create Document class that extends from the Base document.
Use the current Object in your entities relations as needed


    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/Document.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Entity\BaseDocument as BaseDocument;
        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="app_document")
         */
        class Document extends BaseDocument
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

        }

Step 6: Update your database schema
~~~~~~~~~~~~~~~~~~~~~~~~~


.. code-block:: bash

    $ php bin/console doctrine:schema:update --force


Usage Inside form
-----------------

Depend on the relationship, you can use the base form type

For OneToMany relationship:

    .. code-block:: php-annotations

    $builder->add('pictures', CollectionType::class, [
                'entry_type' => PictureType::class // IadTechBundle FormType for picture,
                'by_reference' => false,
                'allow_delete' => true,
                'allow_add' => true,
                'required' => false,
                'label' => false,
                'entry_options' => ['data_class' => BlogPicture::class  // Class created inside the app]
            ]);

For ManyToOne/OneToOne relationship:

    .. code-block:: php-annotations

    $builder->add('document', DocumentType::class // IadTechBundle FormType for document,, [
                'data_class' => BlogDocument::class // Class created inside the app
            ]);


Usage services
-----------------
The bundle offer 2 services:

1. PictureFiler
2. DocumentFiler


1: PictureFiler
~~~~~~~~~~~~~~~

    .. code-block:: php-annotations

        /** @var PictureFiler $filer */
        $filer = $this->get('iad_filer.picture_filer');
        $pictureFiltered = $filer->create($picture, "-1");


2: DocumentFiler
~~~~~~~~~~~~~~~

    .. code-block:: php-annotations

        /** @var DocumentFiler $filer */
        $filer = $this->get('iad_filer.document_filer');
        $doc = $filer->create($picture, "-1");

