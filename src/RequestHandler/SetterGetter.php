<?php

namespace App\RequestHandler;

use Exception;

class SetterGetter
{
    public const TYPE_GET = '_GET';
    public const TYPE_POST = '_POST';
    public const TYPE_SERVER = '_SERVER';
    public const TYPE_COOKIE = '_COOKIE';
    public const TYPE_FILES = '_FILES';
    public const TYPE_HEADERS = 'getallheaders';

    protected array $data = [];
    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->init();
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        if ($value !== null) {
            $this->data[strtolower($key)] = $value;
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        $key = strtolower($key);
        $value = $this->data[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        return $value;
    }

    protected function init(): void
    {
        switch ($this->type) {
            case static::TYPE_POST:
                $this->setArray($_POST);
                $jsonData = file_get_contents('php://input');
                if ($jsonData !== '') {
                    try {
                        $contents = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
                    } catch(Exception $exception) {
                        $contents = null;
                    }
                    if (is_array($contents)) {
                        $this->setArray($contents);
                    }
                }
                break;

            case static::TYPE_HEADERS:
                $fn = $this->type;
                $data = $fn();
                if (is_array($data)) {
                    $this->setArray($data);
                }
                break;

            case static::TYPE_FILES:
                $this->setArray($_FILES);
                break;

            case static::TYPE_COOKIE:
                $this->setArray($_COOKIE);
                break;

            case static::TYPE_GET:
                $this->setArray($_GET);
                break;

            case static::TYPE_SERVER:
                $this->setArray($_SERVER);
                break;
        }
    }

    /**
     * @param array $vkeValuePairs
     */
    protected function setArray(array $vkeValuePairs): void
    {
        foreach ($vkeValuePairs as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}