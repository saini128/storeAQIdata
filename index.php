<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AQI Data</title>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px 12px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
</style>
</head>
<body>

<h1>AQI Data</h1>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>AQI Value</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $jsonFilePath = 'aqi_data.json';
        if (file_exists($jsonFilePath)) {
            $jsonData = file_get_contents($jsonFilePath);
            $data = json_decode($jsonData, true);
	    krsort($data);
            $count = 0;
            foreach ($data as $date => $aqiValue) {
		if ($count >= 20) {
            	break; 
        	}
                echo "<tr>";
                echo "<td>{$date}</td>";
                echo "<td>{$aqiValue}</td>";
                echo "</tr>";
		$count++;
            }
        } else {
            echo "<tr><td colspan='2'>No data available</td></tr>";
        }
        ?>
    </tbody>
</table>
</body>
</html>
