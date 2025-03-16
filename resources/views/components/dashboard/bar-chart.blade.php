<div class="p-6 w-full h-96 rounded-lg shadow-lg bg-base-100">
    <h2 class="mb-4 text-2xl font-bold text-primary">Attendance Overview</h2>
    <div id="barChart"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Attendance',
                data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
            },
            colors: ['#1E40AF']
        };

        var chart = new ApexCharts(document.querySelector("#barChart"), options);
        chart.render();
    });
</script>
