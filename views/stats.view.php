<div class="container">
    <h2>Top 10 des publications les plus lues</h2>
    <canvas id="views_chart"></canvas>
</div>
<?php include('partials/footer.php'); ?>
<script>
$(document).ready(function() {
    $.ajax({
        url: "stats_api.php",
        method: "GET",
        success: function(data) {
            console.log(data);
            let titles = [];
            let views = [];
            datas = JSON.parse(data);
            for (let i = 0; i < datas.length; i++) {
                titles.push(datas[i].title);
                views.push(datas[i].number);
            }
            let chartdata = {
                labels: titles,
                datasets: [{
                    label: 'Les publications les plus vues',
                    backgroundColor: 'rgba(200, 200, 200, 0.75)',
                    borderColor: 'rgba(200, 200, 200, 0.75)',
                    hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                    hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    data: views
                }]
            };

            let ctx = $("#views_chart");

            let barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
</script>