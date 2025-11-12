<?php
$apiKey = "AIzaSyDUmGQECIQZ6CF_9Amviy8-ZqPiMGB0gdE"; 

if (!isset($_FILES['image'])) {
    echo json_encode(["result" => "No image received."]);
    exit;
}

$imageData = base64_encode(file_get_contents($_FILES['image']['tmp_name']));

$payload = [
    "contents" => [
        [
            "parts" => [
                ["text" => "Estimate the calories and describe this food item briefly."],
                ["inline_data" => [
                    "mime_type" => "image/jpeg",
                    "data" => $imageData
                ]]
            ]
        ]
    ]
];

$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$result = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Unable to detect food.';
echo json_encode(["result" => $result]);
?>
