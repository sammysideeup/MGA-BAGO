<?php
// gemini_calorie_estimator.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


$apiKey = "AIzaSyDUmGQECIQZ6CF_9Amviy8-ZqPiMGB0gdE"; 

// --- 1. GET AND PREPARE IMAGE DATA ---

$json_data = file_get_contents('php://input');
if (!$json_data) {
    http_response_code(400);
    echo json_encode(["error" => "No JSON data received"]);
    exit;
}

$data = json_decode($json_data, true);

if (!isset($data['image'])) {
    http_response_code(400);
    echo json_encode(["error" => "Image field not found in JSON payload"]);
    exit;
}

$imageBase64 = $data['image'];

// **CRITICAL FIX:** Strip the Data URL prefix (e.g., "data:image/jpeg;base64,")
$base64_parts = explode(',', $imageBase64);
if (count($base64_parts) !== 2) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid Data URL format. Prefix missing or incorrect."]);
    exit;
}

// This is the clean, raw base64 data to send to Gemini
$cleanBase64Data = $base64_parts[1]; 

// --- 2. BUILD GEMINI PAYLOAD ---

$model = "gemini-2.5-flash"; // Excellent multimodal model for this task
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;

$payload = [
    "contents" => [[
        "parts" => [
            ["text" => "Analyze the food item in the image. Provide a brief description, an estimated portion size (e.g., small, 1 cup, 100g), and a detailed nutritional breakdown for that portion. Structure the response clearly with the following data points:
                 Food Identification and Description
                 Estimated Portion Size
                 Total Estimated Calories (kcal)
                 Macronutrient Breakdown: Protein (g), Total Fat (g), Total Carbohydrates (g)
                 Key Micronutrients: Fiber (g), Sugar (g)
                Present the information in a clear, easy-to-read list format and dont include asterisks."],
            [
                "inline_data" => [
                    "mime_type" => "image/jpeg",
                    "data" => $cleanBase64Data
                ]
            ]
        ]
    ]]
];

$json_payload = json_encode($payload);

// --- 3. MAKE API CALL USING cURL ---

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode(["error" => "cURL Network Error", "details" => $error_msg]);
    exit;
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code != 200) {
    // API Request Failed (e.g., 400 Bad Request, 403 Forbidden due to key issues)
    http_response_code($http_code);
    $error_details = json_decode($response, true) ?? $response;
    echo json_encode(["error" => "Request Failed", "details" => $error_details]);
    exit;
}

// Success: Send the Gemini response back to the frontend
echo $response;
?>