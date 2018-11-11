<?php

namespace Bytesoft\ACL\Activations;

interface ActivationInterface
{
    /**
     * Return the random string used as activation code.
     *
     * @return string
     */
    public function getCode();
}
