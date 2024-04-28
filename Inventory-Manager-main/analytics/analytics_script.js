document.addEventListener("DOMContentLoaded", function() {
    // Fetch data for most firm orders
    fetch('most_firm_orders.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Extract firm names and order counts from the fetched data
        var firmLabels = data.map(entry => entry.firm_name);
        var orderCounts = data.map(entry => entry.order_count);

        // Create chart for most firm orders
        createChart(firmLabels, orderCounts, 'orderChart1', 'Firms with Most Orders', 
                    'rgba(54, 162, 235, 0.5)', 'rgba(54, 162, 235, 1)');
    })
    .catch(error => {
        console.error('Error fetching most firm orders data:', error);
    });

    // Fetch data for most parts ordered
    fetch('most_parts_ordered.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Extract part codes and counts from the fetched data
        var partCodes = data.map(entry => entry.NazivDela);
        var partCounts = data.map(entry => entry.count);

        // Create chart for most parts ordered
        createChart(partCodes, partCounts, 'orderChart2', 'Parts Ordered', 
                    'rgba(255, 99, 132, 0.5)', 'rgba(255, 99, 132, 1)');
    })
    .catch(error => {
        console.error('Error fetching most parts ordered data:', error);
    });

    // Function to create a chart
    function createChart(labels, counts, canvasId, label, backgroundColor, borderColor) {
        // Chart configuration
        var ctx = document.getElementById(canvasId).getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: counts,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
});
