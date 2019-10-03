<?php

namespace App\Controller;

class DefaultController
{
    /**
     * @return array
     */
    public function index(): array
    {
        return [
            'action' => 'Default:index'
        ];
    }
}