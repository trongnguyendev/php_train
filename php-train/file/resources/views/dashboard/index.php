<div class="dashboard-cards">
    <div class="card-item">
        <div class="highlight">40</div>
        <div class="title">Users</div>
    </div>
    <div class="card-item">
        <div class="highlight">15</div>
        <div class="title">Employees</div>
    </div>
    <div class="card-item">
        <div class="highlight">12</div>
        <div class="title">Customers</div>
    </div>
</div>

<section>
    <div class="row">
        <div class="col-md-6">
            <div class="section-title">Biểu đồ</div>
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-md-6">
            <div class="section-title">Lượt truy cập</div>
            <canvas id="myChart2"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const data = <?php echo json_encode($data); ?>;
    const data2 = <?php echo json_encode($data2); ?>;
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
            label: '# of Votes',
            data: data,
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

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels2); ?>,
            datasets: [{
            label: '# of Access',
            data: data2,
            borderWidth: 1
            }]
        },
    });
</script>