<?php

use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

define('DEVELOPMENT_PRODUCTION', '0'); //0 for PRODUCTION
error_reporting(E_ALL);
ini_set("display_errors", DEVELOPMENT_PRODUCTION);
ini_set('log_errors', 1);

function handleExceptions($e)
{
    error_log($e);
    if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN)) {
        echo $e;
    } else {
        $response = new Response("Unexpected error");
        $response->issueResponse(500);
    }
    exit;
}

set_exception_handler('handleExceptions');

set_error_handler(function ($level, $message, $file = '', $line = 0) {
    throw new ErrorException($message, 0, $level, $file, $line);
});
