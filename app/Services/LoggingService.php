<?php

class LoggingService
{
    private string $logFile;

    public function __construct()
    {
        $this->logFile = __DIR__ . '/../../storage/logs/app.log';
    }

    public function log(string $message): void
    {
        $tanggal = date('Y-m-d H:i:s');

        $log = "[$tanggal] $message" . PHP_EOL;

        file_put_contents(
            $this->logFile,
            $log,
            FILE_APPEND
        );
    }
}