<?php

namespace Ates\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AtesUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
