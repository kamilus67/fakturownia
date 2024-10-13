<?php

namespace PiSystems\Fakturownia\Utilities;

use Exception;
use Psr\Log\NullLogger;

class Logger
{
    private static mixed $logger = null;

    private static null|string $customLogPath = null;

    public static function enableLogging(): void
    {
        if (get_class(self::$logger) !== NullLogger::class) {
            throw new Exception('Logging is already enabled');
        }

        self::$logger = new FileLogger(self::$customLogPath);
    }

    public static function disableLogging(): void
    {
        self::$logger = new NullLogger();
    }

    public static function setLogPath(null|string $logPath = null): void
    {
        self::$logger = new FileLogger($logPath);
    }

    public static function getLogger()
    {
        if (is_null(self::$logger)) {
            self::$logger = new FileLogger(self::$customLogPath);
        }

        return self::$logger;
    }

    public static function log(string $title, string $text, string $logLevel = 'info'): void
    {
        $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'Empty server REMOTE_ADDR';
        $content = [
            'ip' => $ip,
            'title' => $title,
            'date' => date('Y-m-d H:i:s'),
            'message' => $text,
            'logLevel' => $logLevel,
        ];

        self::getLogger()->log($logLevel, json_encode($content));
    }

    public static function logLine(string $text): void
    {
        self::getLogger()->logLine($text);
    }
}