<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DieSchittigs\ContaoContentApiBundle\DependencyInjection\ContentApiExtension;

class ContaoContentApiBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ContentApiExtension();
    }
}
