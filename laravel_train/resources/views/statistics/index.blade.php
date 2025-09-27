@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Số khách theo ngày của các Showroom</h2>
    <canvas id="customerChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
async function fetchDataAndRenderChart() {
    try {
        const response = await fetch('/statistics/data');
        const json = await response.json();

        // 1. Tìm tất cả các ngày xuất hiện
        const allLabels = [...new Set(json.map(item => item.customer_for_showroom))].sort();

        // 2. Tìm tất cả showroom
        const showroomNames = [...new Set(json.map(item => item.showroom_name))];

        // 3. Chuẩn hóa dữ liệu: mỗi showroom có giá trị cho tất cả ngày, nếu không có = 0
        const datasets = showroomNames.map((name, idx) => {
            const data = allLabels.map(date => {
                const record = json.find(item => item.showroom_name === name && item.customer_for_showroom === date);
                return record ? record.total_customers : 0;
            });
            const colors = ['red', 'blue', 'green', 'orange', 'purple'];
            return {
                label: name,
                data: data,
                borderColor: colors[idx % colors.length],
                fill: false,
                tension: 0.2
            };
        });

        const chartData = {
            labels: allLabels,
            datasets: datasets
        };

        const config = {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Số khách hàng theo ngày của các Showroom' }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Số khách' } },
                    x: { title: { display: true, text: 'Ngày' } }
                }
            }
        };

        new Chart(document.getElementById('customerChart'), config);

    } catch (error) {
        console.error('Lỗi khi lấy dữ liệu:', error);
    }
}

fetchDataAndRenderChart();
</script>
@endsection
