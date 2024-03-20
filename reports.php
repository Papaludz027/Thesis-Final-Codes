<?php if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED'); ?>

<?= element('header'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Water Consumption</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <?= show_message(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0">
                                Water Consumption
                            </h5>
                        </div>
                        <div class="card-body">
                            <label for="yearSelect" class="">Select Year:</label>
                            <div class="form-group d-flex">
                                <select class="form-control" id="yearSelect" onchange="searchYear(this.value)">
                                    <option value="All">All</option>
                                    <?php
                                    // Fetch distinct years from the database
                                    $year = isset($_GET['year']) ? $_GET['year'] : '';
                                    $query = $DB->prepare("SELECT DISTINCT YEAR(date) AS year FROM watercon ORDER BY year DESC");
                                    $query->execute();
                                    $result = $query->get_result();
                                    while ($row = $result->fetch_object()) {
                                        $sele = ($year == $row->year) ? 'selected' : '';
                                        echo '<option value="' . $row->year . '" ' . $sele . '>' . $row->year . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <hr>
                            <table id="example" class="table table-hover text-sm">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th class="text-center">Total Consumption (cu.m)</th>
                                        <th class="text-center">Total Sales (₱)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['year'])) {
                                        $selectedYear = $_GET['year'];
                                        $query = $DB->prepare("SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(consumption) AS total_consumption, FORMAT(SUM(consumption * price), 2) AS total_sales FROM watercon WHERE YEAR(date) = ? GROUP BY YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) ASC");
                                        $query->bind_param("i", $selectedYear);
                                    } else {
                                        $query = $DB->prepare("SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(consumption) AS total_consumption, FORMAT(SUM(consumption * price), 2) AS total_sales FROM watercon GROUP BY YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) ASC");
                                    }
                                    $query->execute();
                                    $result = $query->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_object()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row->year; ?></td>
                                                <td><?php echo date("F", mktime(0, 0, 0, $row->month, 1)); ?></td>
                                                <td class="text-center"><?php echo $row->total_consumption; ?> cu.m</td>
                                                <td class="text-center">₱<?php echo $row->total_sales; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No data available</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= element('footer'); ?>

<script>
    function searchYear(yearSelect) {
        if (yearSelect === 'All') {
            window.location.href = "";
        } else {
            window.location.href = '?year=' + yearSelect;
        }
    }
</script>
