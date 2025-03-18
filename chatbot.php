<?php
    $api_key = "AIzaSyADDGNPpRPm1Fr6kdzY3aXhzsz-zuy2gvY";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $input = json_decode(file_get_contents("php://input"), true);

    if(!$input || !isset($input['mensaje'])){
        echo json_encode(['error' => 'Entrada no valida']);
        exit;
    }

    $user_mensaje = trim($input['mensaje']);
    $data = [
        "contents" => [
            [
                "parts" => [
                    ['text' => $user_mensaje]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($http_code !== 200){
        echo json_encode(['error' => 'Google Gemini API error']);
        exit;
    }

    $response_data = json_decode($response, true);

    if(!isset($response_data['candidates'][0]['content']['parts'][0]['text'])){
        echo json_encode(['error' => 'Formato de respuesta API inesperado']);
        exit;
    }

    $ai_response = trim($response_data['candidates'][0]['content']['parts'][0]['text']);
    echo json_encode(['response' => $ai_response]);
?>