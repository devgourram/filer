<?php

namespace Iad\Bundle\FilerTechBundle;

use Iad\Bundle\FilerTechBundle\DependencyInjection\Compiler\FilerAdaptersCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class IadFilerTechBundle
 *
 * @package Iad\Bundle\FilerTechBundle
 */
class IadFilerTechBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FilerAdaptersCompilerPass());
    }
}
