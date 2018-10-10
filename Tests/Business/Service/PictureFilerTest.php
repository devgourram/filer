<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 03/10/18
 * Time: 10:18
 */

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

 
use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Business\Service\PictureFiler;
use Iad\Bundle\FilerTechBundle\Config\Configuration;
use Iad\Bundle\FilerTechBundle\Entity\BasePicture;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\DocumentManagerInterface;
use Iad\Bundle\FilerTechBundle\Manager\PictureManager;
use PHPUnit\Framework\TestCase;

class PictureFilerTest extends  \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $idPeople        = -1;
        $filesystem    = $this->getMockFilesystem();
        $pictureManager = $this->getMockPictureManager();
        $imageManager = $this
            ->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        /**
         * @var PictureFiler $pictureFiler
         */
        $pictureFiler   = $this->getPictureFiler($filesystem, $imageManager, $pictureManager);



        $this->assertSame($pictureFiler, $pictureFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $pictureFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $pictureFiler->getFilesystem('public'));

        $this->assertSame($pictureFiler, $pictureFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $pictureFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $pictureFiler->getFilesystem('private'));

        $this->assertSame($pictureFiler, $pictureFiler->setImageManager($imageManager));
        $this->assertEquals($imageManager, $pictureFiler->getImageManager());

        $this->assertSame($pictureFiler, $pictureFiler->setPictureManager($pictureManager));
        $this->assertEquals($pictureManager, $pictureFiler->getPictureManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $file
            ->method('getAccess')
            ->willReturn('public')
        ;


        $this->assertInstanceOf(DocumentObject::class, $pictureFiler->createDocumentObject($file, $idPeople, new BasePicture()));
    }

    /**
     * @param $filesystem
     *
     * @return PictureFiler
     */
    private function getPictureFiler(Filesystem $filesystem, ImageManager $imageManager, PictureManager $pictureManager)
    {
        $encoder = new Encoder();

        $pictureFiler = new PictureFiler($pictureManager, $encoder, $imageManager);

        $pictureFiler->setPublicFilesystem($filesystem);
        $pictureFiler->setPrivateFilesystem($filesystem);

        $config = [BasePicture::class => Configuration::createConfiguration([
            'class' => BasePicture::class,
            'document_type' => 'picture',
            'directory_prefix' => 'picture/'
        ])];

        $pictureFiler->setConfiguration($config);

        return $pictureFiler;
    }

    /**
     * @return Filesystem
     */
    private function getMockFilesystem()
    {
        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->setMethods(['size', 'write'])
            ->getMock();
        $filesystem
            ->method('size')
            ->willReturn(42);
        $filesystem
            ->method('write')
            ->willReturn(42);

        return $filesystem;
    }

    /**
     * @return AvatarManager
     */
    private function getMockPictureManager()
    {
        $manager = $this->getMockBuilder(PictureManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $manager;
    }
}