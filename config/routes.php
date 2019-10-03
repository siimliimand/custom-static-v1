<?php

use App\Configuration\RoutesConfigurationInterface;
use App\Controller\DefaultController;

return [
    '/' => [
        RoutesConfigurationInterface::DATA => [
            RoutesConfigurationInterface::CONTROLLER => DefaultController::class,
            RoutesConfigurationInterface::ACTION => RoutesConfigurationInterface::ACTION_INDEX,
            RoutesConfigurationInterface::METHOD => RoutesConfigurationInterface::METHOD_GET,
            RoutesConfigurationInterface::ACCESS => RoutesConfigurationInterface::ACCESS_PUBLIC
        ]
    ]
];