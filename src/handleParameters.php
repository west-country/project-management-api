<?php

use ProjectManagementApi\Exceptions\InvalidParameterException;

function handleLocaleParameter($localeParameter)
{
    $locale = strtoupper($localeParameter);
    if ($locale !== "US" && $locale !== "UK") {
        throw new InvalidParameterException("Invalid locale");
    }
    return $locale;
}

function handleRequiredNumericalParameter($parameter, $errorMessage)
{
    if (!isset($_GET[$parameter]) || !filter_var($_GET[$parameter], FILTER_VALIDATE_INT)) {
        throw new InvalidParameterException($errorMessage);
    } else {
        return $_GET[$parameter];
    }
}
