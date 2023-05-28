<?php

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

function handleLocaleParameter($localeParameter)
{
    $locale = strtoupper($localeParameter);
    if ($locale !== "US" && $locale !== "UK") {
        $response = new Response("Invalid locale");
        $response->issueResponse(400);
    }
    return $locale;
}
