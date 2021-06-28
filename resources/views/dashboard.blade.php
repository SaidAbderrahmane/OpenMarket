<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<h1>top 10 products by total sales</h1>
<canvas id="myChart" style="max-width: 100; max-height: 100;"></canvas>
<h1>top 10 products by total volume</h1>
<canvas id="myChart2" style="max-width: 100; max-height: 100;"></canvas>
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
<script>
    //total sales 
    //total volume

    let top_10_products_by_amount_json = @json($top_10_products_by_amount);
    let labels = top_10_products_by_amount_json.map(function(e) {
        return e.title;
    });
    let data = top_10_products_by_amount_json.map(function(e) {
        return e.amount;
    });
    console.log(top_10_products_by_amount_json);
    console.log(labels);
    console.log(data);
    let ctx = document.getElementById('myChart');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'total sales ($)',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    let top_10_products_by_volume_json = @json($top_10_products_by_volume);
    let labels2 = top_10_products_by_volume_json.map(function(e) {
        return e.title;
    });
    let data2 = top_10_products_by_volume_json.map(function(e) {
        return e.volume;
    });
    console.log(top_10_products_by_volume_json);
    console.log(labels2);
    console.log(data2);
    let ctx2 = document.getElementById('myChart2');
    let myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels2,
            datasets: [{
                label: 'total volume',
                data: data2,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>