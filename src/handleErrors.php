<?php

use ProjectManagementApi\Response;

error_reporting(E_ALL);

function handleExceptions ($e)
{
    error_log($e);
    if (filter_var(ini_get('display_errors'),FILTER_VALIDATE_BOOLEAN)) {
        echo $e;
    } else {
        $response = new Response("Unexpected error");
        $response->issueResponse(500);
    }
    exit;
}

set_exception_handler('handleExceptions');

set_error_handler(function ($level, $message, $file = '', $line = 0)
{
    throw new ErrorException($message, 0, $level, $file, $line);
});