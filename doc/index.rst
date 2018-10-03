Configuration
=============

Installation
------------

Installation 6 step process:

1. Download IadFilerTechBundle using composer
2. Enable translation
3. Enable the Bundle
4. Create your Picture class or Document
5. Configure the IadFilerTechBundle
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
                // ...
                new \Liip\ImagineBundle\LiipImagineBundle(),
                new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
                new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

                new \Iad\Bundle\CoreBundle\IadCoreBundle(),
                new Iad\Bundle\FilerTechBundle\IadFilerTechBundle(),
                // ...
            );
        }

Step 4: Create your Picture class or Document
~~~~~~~~~~~~~~~~~~~~~~~~~

Create Picture class that extend from the base class.

    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/Picture.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Model\Picture as BasePicture;
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

Create PictureFile class that extend from the base class

    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/PictureFile.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Model\PictureFile as BasePictureFile;
        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="app_pictures_file")
         */
        class PictureFile extends BasePictureFile
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

            /**
             * @var Picture $picture
             * @ORM\ManyToOne(targetEntity="Picture", inversedBy="files")
             * @ORM\JoinColumn(name="id_picture", referencedColumnName="id", nullable=false, onDelete="cascade")
             */
            protected $picture;

        }

OR

For using Document instead of Picture create Document class that extends from the Base document.
Use the current Object in your entities relations as needed


    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/Document.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Model\Document as BaseDocument;
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

Step 5: Configure the IadFilerTechBundle
~~~~~~~~~~~~~~~~~~~~~~~~~

PictureFiler
~~~~~~~~~~~

Base configuration, note that the bundle expose 4 defaults resizing_filters ['small', 'medium', 'high', 'tiny'].

    .. code-block:: yaml

        # app/config/config.yml
        iad_filer_tech:
            picture_filer:
                channel: local
                public_base_url: "%picture_filer.base_url%"
                resizing_filters: ['small', 'tiny']
                class_file: AppBundle\Entity\PictureFile
                class: AppBundle\Entity\Picture
                directory_prefix: 'iad_pictures/'
                document_type: 'pic'


Append the default configuration of the bundle

    .. code-block:: yaml

        #app/config/config.yml
        import:
            - { resource: "@IadFilerTechBundle/Resources/config/config.yml" }


Create parameters for  public & private path.

    .. code-block:: yaml

        parameters:
            filer_channel_local_public_path: path/public
            filer_channel_local_private_path: path/private
            picture_filer.base_url: public/url

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
                class: AppBundle\Entity\Document
                directory_prefix: 'iad_documents/'
                document_type: 'doc'


Step 6: Update your database schema
~~~~~~~~~~~~~~~~~~~~~~~~~


.. code-block:: bash

    $ php bin/console doctrine:schema:update --force


Usage
------------

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

