<?php

function dump(...$data): void
{
    __dump(...$data);
}

function dd(...$data): void
{
    __dump(...$data);
    exit;
}

function __dump(...$data): void
{
    echo '<pre style="border: 1px solid #a0a0a0;padding: 10px;background: #eee; word-wrap: break-word; white-space: pre-wrap;">';
    $backtrace = debug_backtrace();
    $file = $backtrace[1]['file'];
    $line = $backtrace[1]['line'];
    echo "{$file} (Line: {$line})\n";
    print_r($data);
    echo '</pre>';
}

function getMyMicroTime(): int
{
    [$msec, $sec] = explode(' ', microtime());

    return (int) $sec . str_replace('0.', '', $msec);
}

function getClientIP()
{
    $ipaddress = 'UNKNOWN';
    $keys=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');
    foreach($keys as $k)
    {
        if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP))
        {
            $ipaddress = $_SERVER[$k];
            break;
        }
    }
    return $ipaddress;
}