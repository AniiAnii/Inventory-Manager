<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <title>Firms and Parts Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Analitika</h1>

    <div style="display:flex; justify-content:space-around; margin-top:40px; width:50%;">
        <canvas id="orderChart1" style="background-color: rgba(0,0,0,0.8); margin-right:10px; "></canvas>
        <canvas id="orderChart2" style="background-color: rgba(0,0,0,0.8); margin-left:10px; "></canvas>
    </div>

    <div id="firmStatistics" style="margin-top: 20px; margin-right:800px;"></div>
    <div id="partsStatistics" style="margin-top: 20px;"></div>

    <div style="background-color: rgb(0,0,0,0.8);">
        <div style="margin-top: 30px; margin-bottom:20px; padding-top: 20px; padding-bottom:20px; height:400px;">
            <label for="year">Select a year:</label>
            <select id="year">
                <?php
                // Get the current year
                $currentYear = date('Y');
                
                // Display options for the current year and the next five years
                for ($i = 0; $i < 100; $i++) {
                    $year = $currentYear-10 + $i;
                    echo "<option value=\"$year\">$year</option>";
                }
                ?>
            </select>
            <button onclick="fetchAndDisplay()">Fetch Data</button>

            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <script src="analytics_script.js"></script>
    <script src="fetch_orders_per_month.js"></script>
</body>
</html>
