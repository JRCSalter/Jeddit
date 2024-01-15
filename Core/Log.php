<?php

declare(strict_types=1);

namespace Core;

class Log
{
    /**
     * Aborts the script with a HTTP status code.
     * 
     * @param int $status       The status code to send.
     *     Defaults to 404.
     * @param array $attributes An associative array of attributes to pass to
     *     the error page.
     * 
     * return void
     */
    public static function abort(
        int   $status = 404,
        array $attributes = []
    ): void {
        if (!getenv('DEV')) $attributes = [];
        http_response_code((int) $status);
        view("errors/{$status}.php", $attributes);
        die();
    }

    /**
     * Inserts an entry into the log, with a timestamp.
     * 
     * @param array $data The information to log.
     * 
     * @return void
     */
    public static function insert(array $data): void
    {
        $dateString = date('Y-m-d', time());
        $timeString = date('G:i:s', time());
        $line       = 'Unknown line';
        $file       = 'Unknown file';
        $message    = $data['message'];
        
        if (isset($data['e'])) {
            $line = $data['e']->getline();
            $file = $data['e']->getFile();
            $message = $data['e']->getMessage();
        }
        
        if(getenv('FULL_LOG')) {
            foreach (debug_backtrace() as $trace) {
                $message .= "   {$trace['file']}:{$trace['line']}\n";
            }
        }

        $data = "{$dateString} {$timeString}: {$file}:{$line}. {$message}";
        $file = fopen(basePath(getenv('LOG_DIR') . $dateString), 'a');
        fwrite($file, $data . "\n");
        fclose($file);
    }

    /**
     * Inserts an entry into the log, and aborts with the given status code.
     * 
     * @param array $attributes An associative array of attributes to pass to a
     *     view. Must include at least one key labelled 'message'.
     * @param int   $status The HTTP response code to be used.
     *     Defaults to 404.
     * 
     * @return void
     */
    public static function insertAndAbort(
        array $attributes,
        int   $status = 404
    ): void {
        if (!isset($attributes['message'])) {
            $attributes['message'] = 'Unknown error. No message set.';
        }
        static::insert($attributes);
        static::abort($status, $attributes);
    }
}