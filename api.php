<?php
$jsonFilePath = 'aqi_data.json';
$requestBody = file_get_contents('php://input');
$requestData = json_decode($requestBody, true);
$aqiValue = isset($requestData['aqi']) ? intval($requestData['aqi']) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($aqiValue !== null && $aqiValue >= 0) {
      
        $data = [
            date('Y-m-d H:i:s') => $aqiValue
        ];

        if (file_exists($jsonFilePath)) {
            $existingData = json_decode(file_get_contents($jsonFilePath), true);
            $data = array_merge($existingData, $data);
        }

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFilePath, $jsonData)) {
            echo json_encode(['status' => 'success', 'message' => 'AQI data stored successfully. '.$aqiValue]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to store AQI data.','error ' => error_get_last()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid AQI value. '.$requestData]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quest method.']);
}

?>
