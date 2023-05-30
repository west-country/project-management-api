<?php

use ProjectManagementApi\Exceptions\InvalidParameterException;
use ProjectManagementApi\Response;

// function handleLocaleParameter($localeParameter = null) {
//     if (isset($localeParameter)) {
//         $locale = strtoupper($localeParameter);
//         if ($locale !== "US" && $locale !== "UK") {
//             $response = new Response("Invalid locale");
//             $response->issueResponse(400);
//         }
//     } else {
//         $locale = "UK";
//     }
//     return $locale;
// }

// if (isset($_GET['locale'])) {
//     $locale = strtoupper($_GET['locale']);
//     if ($locale !== "US" && $locale !== "UK") {
//         $response = new Response("Invalid locale");
//         $response->issueResponse(400);
//     }
// } else {
//     $locale = "UK";
// }

function handleLocaleParameter($localeParameter)
{
    $locale = strtoupper($localeParameter);
    if ($locale !== "US" && $locale !== "UK") {
        throw new InvalidParameterException("Invalid locale");
        // $response = new Response("Invalid locale");
        // $response->issueResponse(400);
    }
    return $locale;
}

// function handleOptionalNumericalParameters(array $optionalParameters) {
//     foreach($optionalParameters as $parameter => $errorMessage)
//     if (!filter_var($parameter, FILTER_VALIDATE_INT)) {
//         //throw new Exception
//         $response = new Response($errorMessage);
//         $response->issueResponse(400);
//     } else {
//         $$parameter = $parameter
//         $client_id = $_GET['client'];
//         $projectObjects = ProjectHydrator::getProjectsByClient($pdo, $client_id, $locale);
//         $response = new Response('Successfully retrieved project', $projectObjects);
//         $response->issueResponse(200);
//     }
// } else {
//     $projectObjects = ProjectHydrator::getAllProjects($pdo, $locale);
//     $response = new Response('Successfully retrieved projects', $projectObjects);
//     $response->issueResponse(200);
// }

function handleRequiredNumericalParameter($parameter, $errorMessage)
{
    if (isset($_GET[$parameter])) {
        if (!filter_var($_GET[$parameter], FILTER_VALIDATE_INT)) {
            throw new InvalidParameterException($errorMessage);
            // $response = new Response($errorMessage);
            // $response->issueResponse(400);
        } else {
            //$$parameter = $_GET[$parameter];
            return $_GET[$parameter];
        }
    } else {
        throw new InvalidParameterException($errorMessage);

        // $response = new Response($errorMessage);
        // $response->issueResponse(400);
    }
}
