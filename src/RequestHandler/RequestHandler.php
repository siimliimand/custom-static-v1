<?php

namespace App\RequestHandler;

use App\Configuration\RoutesConfigurationInterface;
use App\Controller\ControllerFactory;
use App\Exception\InvalidRouteException;
use App\Exception\UnauthorizedException;
use App\Route\RouteManager;

class RequestHandler
{
    public const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @param Request $request
     * @throws UnauthorizedException
     * @throws InvalidRouteException
     */
    public function handle(Request $request): void
    {
        $routeData = RouteManager::getRouteData($request);
        static::checkApiKey($request, $routeData);

        $response = ControllerFactory::callControllerByRouteData($routeData, $request);
        $this->sendResponse($response, Response::HTTP_OK, $request);
    }

    /**
     * @param Request $request
     * @param array $routeData
     * @throws UnauthorizedException
     */
    protected static function checkApiKey(Request $request, array $routeData): void
    {
        $apiToken = $request->headers->get('X-API-KEY', null);
        if ($routeData[RoutesConfigurationInterface::ACCESS] === RoutesConfigurationInterface::ACCESS_PRIVATE &&
        $apiToken !== env('API_TOKEN')) {
            throw new UnauthorizedException('Unauthorized');
        }
    }

    /**
     * @param array $content
     * @param int $statusCode
     * @param Request $request
     */
    protected function sendResponse(array $content, int $statusCode, Request $request): void
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', static::CONTENT_TYPE_JSON);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'deny');
        $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));
        $response->headers->set('x-api-key', $request->headers->get('x-api-key'));
        $response->setContent(json_encode($content, JSON_THROW_ON_ERROR, 512));
        $response->send();
    }
}