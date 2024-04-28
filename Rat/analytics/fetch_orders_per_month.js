// Function to fetch data and display chart
function fetchAndDisplay() {
    // Get the selected year from the dropdown list
    var year = document.getElementById('year').value;

    // Fetch data for orders per month in the selected year
    fetch('orders_per_month.php?year=' + year)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Define an array of month names
        var monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Extract month labels and order counts from the fetched data
        var monthLabels = data.map(entry => monthNames[parseInt(entry.month) - 1]); // Convert month number to month name
        var orderCounts = data.map(entry => parseInt(entry.order_count)); // Convert order count to integer

        // Create or replace canvas element
        var canvas = document.getElementById('orderChart');
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'orderChart';
            document.body.appendChild(canvas);
        }

        // Clear previous chart if it exists
        var ctx = canvas.getContext('2d');
        if (ctx.chart) {
            ctx.chart.destroy();
        }

        // Create new chart
        createChart(monthLabels, orderCounts);
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}

// Function to create chart
function createChart(labels, counts) {
    var ctx = document.getElementById('orderChart').getContext('2d');
    ctx.chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders per Month',
                data: counts,
                backgroundColor: 'rgba(44,255,90,0.5)',
                borderColor: 'rgba(255, 255, 0, 1)',
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

// Add event listener to the button
document.getElementById('fetchButton').addEventListener('click', fetchAndDisplay);
