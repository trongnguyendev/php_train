@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Thống kê khách hàng</h2>

    <div class="row">
        <!-- Chart 1 -->
        <div class="col-md-6 mb-4">
            <h5>Theo showroom (tất cả khách hàng)</h5>
            <canvas id="chart1" height="150"></canvas>
        </div>

        <!-- Chart 2 -->
        <div class="col-md-6 mb-4">
            <h5>Khách hàng mới + Tiềm năng theo showroom</h5>
            <canvas id="chart2" height="150"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Adapter để Chart.js hiểu dữ liệu ngày -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("{{ route('statistics.data') }}")
        .then(res => res.json())
        .then(result => {
            let data = result.data;           // tất cả khách
            let dataChart2 = result.dataChart2; // khách mới + tiềm năng

            // -------- CHART 1: Theo showroom ----------
            let grouped1 = {};
            data.forEach(item => {
                if (!grouped1[item.showroom_name]) {
                    grouped1[item.showroom_name] = [];
                }
                grouped1[item.showroom_name].push({
                    x: item.ngay,
                    y: item.tong_khach
                });
            });

            let datasets1 = Object.keys(grouped1).map((name, i) => ({
                label: name,
                data: grouped1[name],
                borderColor: `hsl(${i * 60}, 70%, 50%)`,
                borderWidth: 2,
                fill: false,
                tension: 0.1
            }));

            new Chart(document.getElementById("chart1"), {
                type: 'line',
                data: { datasets: datasets1 },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        x: {
                            type: 'time',
                            time: { unit: 'day' },
                            title: { display: true, text: 'Ngày' }
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Số khách' }
                        }
                    }
                }
            });

            // -------- CHART 2: Khách hàng mới + Tiềm năng theo showroom ----------
            let grouped2 = {};
            dataChart2.forEach(item => {
                if (!grouped2[item.showroom_name]) {
                    grouped2[item.showroom_name] = [];
                }
                grouped2[item.showroom_name].push({
                    x: item.ngay,
                    y: item.tong_khach
                });
            });

            let datasets2 = Object.keys(grouped2).map((name, i) => ({
                label: name,
                data: grouped2[name],
                borderColor: `hsl(${i * 60 + 180}, 70%, 50%)`, // shift màu khác chart1
                borderWidth: 2,
                fill: false,
                tension: 0.1
            }));

            new Chart(document.getElementById("chart2"), {
                type: 'line',
                data: { datasets: datasets2 },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        x: {
                            type: 'time',
                            time: { unit: 'day' },
                            title: { display: true, text: 'Ngày' }
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Số khách' }
                        }
                    }
                }
            });
        });
});
</script>
@endsection
