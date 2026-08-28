<?php
$url = 'http://127.0.0.1:8000/';
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: PHP\r\n",
        'follow_location' => 1,
    ],
];
$ctx = stream_context_create($opts);
$html = file_get_contents($url, false, $ctx);
if (!$html) {
    echo "Failed to fetch login page\n";
    exit(1);
}
if (!preg_match('/name="_token" value="([^"]+)"/', $html, $m)) {
    echo "CSRF token not found\n";
    exit(1);
}
$token = $m[1];
$postData = http_build_query([
    '_token' => $token,
    'email' => 'jamesnapalya79@gmail.com',
    'password' => 'James@2025*',
    'remember' => 'on',
]);
$opts = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\nUser-Agent: PHP\r\n",
        'content' => $postData,
        'follow_location' => 0,
    ],
];
$ctx = stream_context_create($opts);
$response = @file_get_contents('http://127.0.0.1:8000/login', false, $ctx);
if ($response === false) {
    echo "Request failed\n";
    if (isset($http_response_header)) {
        echo implode("\n", $http_response_header) . "\n";
    }
    exit(1);
}
echo "--- Response Headers ---\n";
echo implode("\n", $http_response_header) . "\n";
echo "--- Body Snippet ---\n";
echo substr($response, 0, 1000) . "\n";
