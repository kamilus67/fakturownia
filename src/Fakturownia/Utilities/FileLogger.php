<?php

namespace PiSystems\Fakturownia\Utilities;

use Exception;

class FileLogger
{
    private null|string $logFilePath = null;

    public function __construct(null|string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    public function log(string $level, string $message, array $context = []): void
    {
        $this->info($message);
    }

    public function logLine(string $text): void
    {
        $this->checkLogFile();
        file_put_contents($this->getLogPath(), $text . PHP_EOL, FILE_APPEND);
    }

    public function info(string $message): void
    {
        $content = json_decode($message, true);
        $logText = PHP_EOL . '===========================';
        $logText .= PHP_EOL . $content['title'];
        $logText .= PHP_EOL . '===========================';
        $logText .= PHP_EOL . $content['date'];
        $logText .= PHP_EOL . 'ip: ' . $content['ip'];
        $logText .= PHP_EOL;
        $logText .= $content['message'];
        $logText .= PHP_EOL;

        $this->checkLogFile();
        file_put_contents($this->getLogPath(), $logText, FILE_APPEND);
    }

    private function getLogPath(): string
    {
        $logFileName = sprintf('log_%s.log', date('Y-m-d'));

        if (is_null($this->logFilePath)) {
            $logPath = sprintf('%s/../../../Logs/%s', __DIR__, $logFileName);
        } else {
            $logPath = $this->logFilePath . $logFileName;
        }

        return $logPath;
    }

    private function checkLogFile(): void
    {
        $logFilePath = $this->getLogPath();

        if (!file_exists($logFilePath)) {
            file_put_contents($logFilePath, '<?php exit; ?> ' . PHP_EOL);
            chmod($logFilePath, 0644);
        }

        if (!file_exists($logFilePath) || !is_writable($logFilePath)) {
            throw new Exception('Unable to create or write the log file ' . $logFilePath);
        }
    }
}