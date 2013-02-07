<?php

namespace Wabbox\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WabboxUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
