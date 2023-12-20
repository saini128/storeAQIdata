<?php

// Define the path to the JSON file
$jsonFilePath = 'aqi_data.json';
$requestBody = file_get_contents('php://input');
$requestData = json_decode($requestBody, true);
$aqiValue = isset($requestData['aqi']) ? intval($requestData['aqi']) : null;
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the AQI value from the request
    
    if ($aqiValue !== null && $aqiValue >= 0) {
        // Create an associative array with the current datetime as the key and AQI value as the value
        $data = [
            date('Y-m-d H:i:s') => $aqiValue
        ];

        // Check if the JSON file exists
        if (file_exists($jsonFilePath)) {
            // Get the existing data from the JSON file
            $existingData = json_decode(file_get_contents($jsonFilePath), true);
            // Merge the new data with existing data
            $data = array_merge($existingData, $data);
        }

        // Encode the data array to JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Write the JSON data to the file
        if (file_put_contents($jsonFilePath, $jsonData)) {
            echo json_encode(['status' => 'success', 'message' => 'AQI data stored successfully.'.$aqiValue]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to store AQI data.','error' => error_get_last()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid AQI value.'.$requestData]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quest method.']);
}

?>
