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
        ],
        RoutesConfigurationInterface::ROUTES => [
            'upload' => [
                RoutesConfigurationInterface::DATA => [
                    RoutesConfigurationInterface::CONTROLLER => DefaultController::class,
                    RoutesConfigurationInterface::ACTION => 'upload',
                    RoutesConfigurationInterface::METHOD => RoutesConfigurationInterface::METHOD_POST,
                    RoutesConfigurationInterface::ACCESS => RoutesConfigurationInterface::ACCESS_PRIVATE
                ]
            ]
        ]
    ]
];