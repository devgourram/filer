<?php
/**
 * Created by PhpStorm.
 * User: elfassihicham
 * Date: 04/06/2015
 * Time: 11:35
 */

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;

/**
 * Class DocumentObjectTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class DocumentObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $documentObject = new DocumentObject();

        $now        = new \DateTime();
        $uuid       = hash('sha256', 'Test du sha256 pour les filers');
        $details    = ['origin', 'test'];

        $className = 'Iad\Bundle\FilerTechBundle\Entity\DocumentObject';

        $this->assertNull($documentObject->getId());

        $this->assertInstanceOf($className, $documentObject->setUuid($uuid));
        $this->assertEquals($uuid, $documentObject->getUuid());

        $this->assertInstanceOf($className, $documentObject->setCreatedAt($now));
        $this->assertEquals($now, $documentObject->getCreatedAt());

        $this->assertInstanceOf($className, $documentObject->setAccess('private'));
        $this->assertEquals('private', $documentObject->getAccess());

        $this->assertInstanceOf($className, $documentObject->setCheckSum('sha2'));
        $this->assertEquals('sha2', $documentObject->getCheckSum());

        $this->assertInstanceOf($className, $documentObject->setMimeType('application/pdf'));
        $this->assertEquals('application/pdf', $documentObject->getMimeType());

        $this->assertInstanceOf($className, $documentObject->setSize('small'));
        $this->assertEquals('small', $documentObject->getSize());

        $this->assertInstanceOf($className, $documentObject->setFullName('full-file_name'));
        $this->assertEquals('full-file_name', $documentObject->getFullName());

        $this->assertInstanceOf($className, $documentObject->setOriginalName('full-file_name'));
        $this->assertEquals('full-file_name', $documentObject->getOriginalName());

        $this->assertInstanceOf($className, $documentObject->setIdUploader('caller'));
        $this->assertEquals('caller', $documentObject->getIdUploader());

        $this->assertInstanceOf($className, $documentObject->setPathDirectory('/dir/to/file/name'));
        $this->assertEquals('/dir/to/file/name', $documentObject->getPathDirectory());

        $this->assertInstanceOf($className, $documentObject->setDocumentType('origin'));
        $this->assertEquals('origin', $documentObject->getDocumentType());

        $this->assertInstanceOf($className, $documentObject->setDetails($details));
        $this->assertEquals($details, $documentObject->getDetails());
    }

    /**
     * @expectedException \Exception
     */
    public function testWrongAccess()
    {
        $documentObject = new DocumentObject();
        $documentObject->setAccess('unknown');
    }
}
