<?php

namespace App\Controller;

use App\RequestHandler\Request;
use App\Repository\ImageRepository;
use RuntimeException;

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

    /**
     * @param Request $request
     * @return array
     */
    public function upload(Request $request): array
    {
        try {
            $base64Image = $request->request->get('image');
            $filename = $request->request->get('filename');
            $data = explode(',', $base64Image);
            if (!isset($data[1])) {
                throw new RuntimeException('Invalid image');
            }
            $content = base64_decode($data[1]);

            $imageId = ImageRepository::insert($filename, '');
            if ($imageId === null) {
                throw new RuntimeException('Invalid image');
            }

            $path = '';
            if ($imageId > 1000000) {
                $nr = floor($imageId / 1000000);
                $imageId -= ($nr * 1000000);
                $path .= $nr . '/';
            } else {
                $path .= '0/';
            }
            $concurrentDirectory = IMAGES_PATH . $path;
            if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            if ($imageId > 1000) {
                $nr = floor($imageId / 1000);
                $imageId -= ($nr * 1000);
                $path .= $nr . '/';
            } else {
                $path .= '0/';
            }
            $concurrentDirectory = IMAGES_PATH . $path;
            if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            $path .= $imageId . '/';
            $concurrentDirectory = IMAGES_PATH . $path;
            if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            ImageRepository::updatePath($imageId, $path);

            $file = fopen(IMAGES_PATH . $path . $filename, 'wb');
            $response = fwrite($file, $content);
            fclose($file);

            if ($response === false) {
                throw new RuntimeException('Invalid image');
            }
        } catch (RuntimeException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }

        return [
            'OK'
        ];
    }
}