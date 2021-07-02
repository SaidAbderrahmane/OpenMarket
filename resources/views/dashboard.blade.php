<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto;
        /* background-color: #2196F3; */
        padding: 10px;
    }

    .grid-item {
        /* background-color: rgba(255, 255, 255, 0.8); */
        /* border: 1px solid rgba(0, 0, 0, 0.8); */
        padding: 20px;
        /* font-size: 30px; */
        text-align: center;
    }

    button {
        background-color: black;
        color: white;
        border: 0;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
<div style="text-align:center; font-size: 14pt;">
    <p>Date range : </p>
    <!-- <form action="/admin{date_range}"> -->
    <select name="date_range" id="date_range">
        <option value="0 days">today</option>
        <option value="5 days">last 5 days</option>
        <option value="1 week">last week</option>
        <option value="1 month">last month</option>
        <option value="3 months">last 3 month</option>
        <option value="1 year">last year</option>
        <option value="5 years">last 5 years</option>
        <option value="all time" selected>all time</option>
    </select>
    <button id="apply_date_range">Apply</button>
    </form>
</div>
<div class="grid-container">
    <div class="grid-item">
        <h1>categories by total sales</h1>
        <canvas id="categories_sales" style="max-width: 90% !important; max-height: 350px !important;"></canvas>
    </div>
    <div class="grid-item">
        <div style=" margin:20%; padding:10%; height: auto; width: 70%; font-size:32pt; background-color:grey; color:white;">
            Revenue <br> @if($capital)
            {{number_format($capital,2)}}
            @else {{0}}
            @endif $
        </div>
    </div>
    <div class="grid-item">
        <h1>top 10 products by total sales</h1>
        <canvas id="top_products_sales" style="max-width: 90% !important; max-height: 350px !important;"></canvas>
    </div>
    <div class="grid-item">
        <h1>top 10 products by total volume</h1>
        <canvas id="top_products_volume" style="max-width: 90% !important; max-height: 350px !important;"></canvas>
    </div>
    <div class="grid-item">
        <h1>top 10 clients by total sales</h1>
        <canvas id="top_clients_sales" style="max-width: 90% !important; max-height: 350px !important;"></canvas>
    </div>
    <div class="grid-item">
        <h1>top 10 clients by total volume</h1>
        <canvas id="top_clients_volume" style="max-width: 90% !important; max-height: 350px !important;"></canvas>
    </div>

    <script>
        //total sales 
        //total volume
        const COLORS = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(107, 138, 232)',
            'rgba(240, 48, 227)',
        ];
        const BORDER_COLORS = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(3, 0, 77)',
            'rgba(128, 5, 119)',
        ];

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
        let ctx = document.getElementById('top_products_sales');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'total sales ($)',
                    data: data,
                    backgroundColor: COLORS,
                    borderColor: BORDER_COLORS,
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
        let ctx2 = document.getElementById('top_products_volume');
        let myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'total volume',
                    data: data2,
                    backgroundColor: COLORS,
                    borderColor: BORDER_COLORS,
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
        let top_10_clients_by_volume_json = @json($top_10_clients_by_volume);
        let labels3 = top_10_clients_by_volume_json.map(function(e) {
            return e.name;
        });
        let data3 = top_10_clients_by_volume_json.map(function(e) {
            return e.volume;
        });
        console.log(top_10_clients_by_volume_json);
        console.log(labels3);
        console.log(data3);
        let ctx3 = document.getElementById('top_clients_volume');
        let myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: labels3,
                datasets: [{
                    label: 'total volume',
                    data: data3,
                    backgroundColor: COLORS,
                    borderColor: BORDER_COLORS,
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

        // ------------------- top 10 clients by total sales --------------


        let top_10_clients_by_amount_json = @json($top_10_clients_by_amount);
        let labels4 = top_10_clients_by_amount_json.map(function(e) {
            return e.name;
        });
        let data4 = top_10_clients_by_amount_json.map(function(e) {
            return e.amount;
        });
        console.log(top_10_clients_by_amount_json);
        console.log(labels4);
        console.log(data4);
        let ctx4 = document.getElementById('top_clients_sales');
        let myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: labels4,
                datasets: [{
                    label: 'total volume',
                    data: data4,
                    backgroundColor: COLORS,
                    borderColor: BORDER_COLORS,
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

        // ------------------- categories --------------


        let categories_by_amount_json = @json($categories_by_amount);
        let labels5 = categories_by_amount_json.map(function(e) {
            return e.name;
        });
        let data5 = categories_by_amount_json.map(function(e) {
            return e.amount;
        });
        console.log(categories_by_amount_json);
        console.log(labels5);
        console.log(data5);
        let ctx5 = document.getElementById('categories_sales');
        let myChart5 = new Chart(ctx5, {
            type: 'pie',
            data: {
                labels: labels5,
                datasets: [{
                    label: 'total sales',
                    data: data5,
                    backgroundColor: BORDER_COLORS,
                    borderColor: COLORS,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        // text: 'categories by amount'
                    }
                }
            },
        });

        // date filter
        const urlParams = new URLSearchParams(window.location.search);
        var date_range = document.getElementById("date_range");
        if (urlParams.get('date_range') != null)
            date_range.value = urlParams.get('date_range');
        document.getElementById("apply_date_range").addEventListener('click', applyRange, false);
        //date_range.addEventListener('click', {})
        function applyRange() {
            urlParams.set('date_range', date_range.value);
            //console.log(JSON.stringify(range.noUiSlider.get()), available.value);
            window.location.search = urlParams;
        }
    </script>