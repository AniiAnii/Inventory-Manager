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

    <div style= 'background-color: rgb(0,0,0,0.5); padding-top:20px;'>

    <div style="display:flex; justify-content:space-around; margin-top:40px; width:50%;">
        <canvas id="orderChart1" style="background-color: rgba(0,0,0,0.5); margin-right:10px; "></canvas>
        <canvas id="orderChart2" style="background-color: rgba(0,0,0,0.5); margin-left:10px; "></canvas>
    </div>

    <div style="background-color: rgb(0,0,0,0.5);">
        <div style="margin-top: 30px; margin-bottom:20px; padding-top: 20px; padding-bottom:80px; height:400px;">
            <label for="year">Odaberi godinu:</label>
            <select id="year">
                <?php
                // Get the current year
                $currentYear = date('Y');
                
                for ($i = 0; $i < 100; $i++) {
                    $year = $currentYear-10 + $i;
                    echo "<option value=\"$year\">$year</option>";
                }
                ?>
            </select>
            <button class='button' style='width: 80px; height: 30px; display: flex; justify-content: center; align-items: center;' onclick="fetchAndDisplay()">Prikaži</button>

            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <button id="fetchButton" class="button" style=" margin-top:20px; margin-bottom:20px;" >Fetch Firm Orders</button>

    <div id="firmOrdersContainer"></div>

    <script src="analytics_script.js"></script>
    <script src="fetch_orders_per_month.js"></script>
    <script>
        document.getElementById("fetchButton").addEventListener("click", function() {
            var container = document.getElementById("firmOrdersContainer");

            // If the container is currently displaying the fetched data, hide it
            if (container.innerHTML.trim() !== '') {
                container.innerHTML = '';
            } else {
                // If the container is empty, fetch and display the data
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        container.innerHTML = this.responseText;
                    }
                };
                xhr.open("POST", "orders_per_firm.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("fetchOrders=true");
            }
        });
    </script>

    </div>
</body>
</html>
