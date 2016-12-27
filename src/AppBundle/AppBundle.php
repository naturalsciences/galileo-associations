<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Adldap2Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            return new Adldap2Extension();
        }
        return $this->extension;
    }
}
