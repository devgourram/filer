<?php
/**
 * Created by PhpStorm.
 * User: elfassihicham
 * Date: 04/06/2015
 * Time: 11:50
 */

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\TestBundle\Tests\DoctrineMockTrait;
use Iad\Bundle\TestBundle\Tests\AbstractManagerTrait;
use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;

/**
 * Class DocumentObjectManagerTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class DocumentObjectManagerTest extends \PHPUnit_Framework_TestCase
{
    use AbstractManagerTrait, DoctrineMockTrait;

    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $em = $this->buildEntityManagerMock();
        $manager = new DocumentObjectManager($em);

        $this->addManagerTest($em, $manager, 'Iad\Bundle\FilerTechBundle\Entity\DocumentObject', 'IadFilerTechBundle:DocumentObject');
    }
}
