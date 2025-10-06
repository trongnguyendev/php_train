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

        <!-- Chart 3 -->
        <div class="col-md-12 mb-4">
            <h5>Khách hàng cũ + Tiềm năng (TT Quận 1)</h5>
            <canvas id="chart3" height="150"></canvas>
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
            let data = result.data;           // dữ liệu chart 1
            let dataChart2 = result.dataChart2; // dữ liệu chart 2
            let countKH = result.countKH;     // dữ liệu chart 3 (KH cũ + Tiềm năng TT Q1)

            // ---------------------- CHART 1 ----------------------
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

            // ---------------------- CHART 2 ----------------------
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
                borderColor: `hsl(${i * 60 + 180}, 70%, 50%)`,
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

            // ---------------------- CHART 3 ----------------------
            if (Array.isArray(countKH)) {
                let grouped3 = {};
                countKH.forEach(item => {
                    if (!grouped3[item.showroom_name]) {
                        grouped3[item.showroom_name] = [];
                    }
                    grouped3[item.showroom_name].push({
                        x: item.ngay,
                        y: item.tong_khach
                    });
                });

                let datasets3 = Object.keys(grouped3).map((name, i) => ({
                    label: name,
                    data: grouped3[name],
                    borderColor: `hsl(${i * 60 + 300}, 70%, 50%)`,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }));

                new Chart(document.getElementById("chart3"), {
                    type: 'line',
                    data: { datasets: datasets3 },
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
            } else {
                // Nếu chỉ trả về 1 số tổng count, thì hiển thị ra console
                console.log("Tổng KH TT Q1 (KH cũ + tiềm năng):", countKH);
            }
        })
        .catch(err => console.error("Lỗi khi tải dữ liệu thống kê:", err));
});
</script>
@endsection
