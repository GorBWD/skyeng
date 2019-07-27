<?php 

const STATUS = array(
    200 => '200 OK',
    400 => '400 Bad Request',
    422 => 'Unprocessable Entity',
    500 => '500 Internal Server Error'
);


function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Skyeng test task');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType('offline');

    $jsonAuth = file_get_contents('token.json');

    $client->setAuthConfig(json_decode($jsonAuth, true));
   
    return $client;
}

function json_response($message = null, $code = 200)
{
    header_remove();
    http_response_code($code);
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    header('Content-Type: application/json');
    
    header('Status: '.STATUS[$code]);

    return json_encode(array(
        'status' => $code < 300,
        'message' => $message
    ));
}


$client = getClient();
$service = new Google_Service_Sheets($client);

$spreadsheetId = '1zADSepqdAeiYNfpMOZmIGm7bJzqYSQ3l0tt9gGIQUHU';

$name = $_POST['name'];
$email = $_POST['email'];
$formType = $_POST['type'];

if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    return json_response("Invalid Email.", 422);
}

$values = [
    [ $name, $email, $formType ]
];

$body = new Google_Service_Sheets_ValueRange([
    'values' => $values
]);

$params = [
    'valueInputOption' => 'RAW'
];
$result = $service->spreadsheets_values->append($spreadsheetId, 'A:A', $body, $params);

json_response("Success.", 200);
