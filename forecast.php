<?php
require_once('includes/load.php');

// Fetch monthly sales grouped by product
$sql = "
    SELECT 
        product_id, 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(qty) AS total_sales
    FROM sales
    GROUP BY product_id, month
    ORDER BY product_id, month
";

$result = $db->query($sql);

$sales_data = [];
while ($row = $result->fetch_assoc()) {
    $sales_data[$row['product_id']][] = [
        'month' => $row['month'],
        'total_sales' => $row['total_sales']
    ];
}

// Calculate 3-month moving average
$forecast_data = [];
foreach ($sales_data as $product_id => $sales) {
    for ($i = 0; $i < count($sales); $i++) {
        if ($i < 3) {
            $forecast = $sales[$i]['total_sales']; // Not enough data, use actual
        } else {
            $forecast = ($sales[$i - 1]['total_sales'] + $sales[$i - 2]['total_sales'] + $sales[$i - 3]['total_sales']) / 3;
        }

        $actual = $sales[$i]['total_sales'];
        $error = ($actual != 0) ? number_format((($actual - $forecast) / $actual) * 100, 2) : 0;

        $forecast_data[] = [
            'product_id' => $product_id,
            'month' => $sales[$i]['month'],
            'actual_sales' => $actual,
            'forecast_sales' => round($forecast, 2),
            'error' => $error . '%'
        ];
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="workboard__heading">
	<h1 class="workboard__title">Sales</h1>
</div>
<div class="workpanel report__main">
	<div class="row">
		<div class="col xs-12">
			<div class="row">
				<div class="col xs-12">
					<div class="meta-info">
						<div class="row">
							<div class="col xs-12 sm-6">
								<h2 class="subheading">Selling Products</h2>
							</div>
							<div class="col xs-12 sm-6">
								<form method="POST">
									<div class="site-panel">
										<div class="form__module">
											<div class="form__action">
												<span class="icon-add"></span>
												<input type="submit" class="button primary-tint" value="Add sales" name="add_sale">
											</div>
										</div>
										<div class="downoad">
											<a href="" id="download_btn"><span class="icon-download"></span>Download</a>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col xs-12">
								<div class="questionaries__showcase" id="question_popup" style="display: flex;">
									<div class="tbl-wrap">
										<table id="sales__table">
											<thead>
                                            <tr>
        <th>Product ID</th>
        <th>Month</th>
        <th>Actual Sales</th>
        <th>Forecasted Sales</th>
        <th>Percentage Error (%)</th>
    </tr>
											</thead>
											<tbody>

                                            <?php foreach ($forecast_data as $data): ?>
    <tr>
        <td><?php echo $data['product_id']; ?></td>
        <td><?php echo $data['month']; ?></td>
        <td><?php echo $data['actual_sales']; ?></td>
        <td><?php echo $data['forecast_sales']; ?></td>
        <td><?php echo $data['error']; ?></td>
    </tr>
    <?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>