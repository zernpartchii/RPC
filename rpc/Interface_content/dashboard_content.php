<?php


$sql = "SELECT COUNT(Zone) AS 'Zone' FROM `research_information`;";
$result1 = mysqli_query($con, $sql);

if ($row = $result1->fetch_assoc()) {

  $zone = $row["Zone"];
}

$sql = "SELECT COUNT(DISTINCT(Program)) AS 'Program' FROM `research_information`;";
$result = mysqli_query($con, $sql);

if ($row = $result->fetch_assoc()) {

  $program = $row["Program"];
}

$sql = "SELECT COUNT(Title) AS 'Title' FROM `research_information`;";
$result = mysqli_query($con, $sql);

if ($row = $result->fetch_assoc()) {

  $title = $row["Title"];
}

$sql = "SELECT COUNT(Proponents) AS 'Proponents' FROM `Proponents` WHERE Proponents NOT IN('');";
$result = mysqli_query($con, $sql);

if ($row = $result->fetch_assoc()) {

  $proponents = $row["Proponents"];
}

?>

<style>
.dash-card {
    background-color: rgb(255, 200, 50);
}
</style>


<!-- Start Card -->

<div class="row m-0 p-3 w-100">
    <div class="col-md-12 mb-3 d-inline-flex mb-3">
        <div class="card border-0 w-100 border-bottom">
            <div class="card-body d-flex align-items-center p-0">
                <a class="fs-2 font-monospace text-dark me-auto text-decoration-none">DASHBOARD</a>
                <a href="addResearch.php" class="btn btn-sm mb-2 mx-2 btn-primary"><i class="bi-plus-circle"></i> Add
                    Research</a>
                <a href="reports.php" class="btn btn-sm mb-2 btn-danger"><i class="bi-cloud-download-fill"></i> Generate
                    report</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 dash-card shadow h-100 bg-primary">
            <div class="card-body bg-body mt-3 mb-1 pt-4 pb-3">
                <h5 class="font-monospace text-uppercase fw-bold border-primary border-bottom pb-2 mb-2 text-dark">Zone:
                    <?php echo $zone; ?></h5>
                <div class="d-block text-dark">Total of Zone</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 dash-card shadow h-100 bg-warning">
            <div class="card-body bg-body mt-3 mb-1 pt-4 pb-3">
                <h5 class="font-monospace text-uppercase fw-bold border-warning border-bottom pb-2 mb-2 text-dark">
                    Program: <?php echo $program; ?></h5>
                <div class="d-block text-dark">Total of Program</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 dash-card shadow h-100 bg-success">
            <div class="card-body bg-body mt-3 mb-1 pt-4 pb-3">
                <h5 class="font-monospace text-uppercase fw-bold border-success border-bottom pb-2 mb-2 text-dark">
                    Research: <?php echo $title; ?></h5>
                <div class="d-block text-dark">Total of Research</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 dash-card shadow h-100 bg-info">
            <div class="card-body bg-body mt-3 mb-1 pt-4 pb-3">
                <h5 class="font-monospace text-uppercase fw-bold border-info border-bottom pb-2 mb-2 text-dark">
                    Proponents: <?php echo $proponents; ?></h5>
                <div class="d-block text-dark">Total of Proponents</div>
            </div>
        </div>
    </div>


    <!-- include chart js  -->
    <script src="js/chart.js"></script>
    <script src="js/chartLabel.js"></script>

    <?php


  $sql = "SELECT DISTINCT(z.Zone) AS 'Zone' FROM research_information r 
  JOIN Zone z ON z.id = r.Zone ORDER BY z.Zone DESC";
  $result1 = mysqli_query($con, $sql);

  $zoneDepartment = array();
  foreach ($result1 as $zone) {
    $zoneDepartment[] = $zone['Zone'];
  }

  if ($result->num_rows > 0) {

    for ($course = 0; $course < count($zoneDepartment); $course++) {

      $college = $zoneDepartment[$course];
      $sql = "SELECT COUNT(z.Zone) AS 'Zone' FROM `research_information` r 
      JOIN Zone z ON z.id = r.Zone WHERE z.Zone = '$college';";
      $result = mysqli_query($con, $sql);

      if ($row = $result->fetch_assoc()) {
        $Zone[] = $row["Zone"];
      }
    }
  }

  if (count($zoneDepartment) == 0) {

    $_SESSION['status'] = "No available charts to show because no data in the Research table.";

    if (isset($_SESSION['status'])) { ?>

    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
        <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
    </div>

    <?php
      unset($_SESSION['status']);
    }

    ?>
    <div class="col-md-4 mt-3">
        <canvas id="myChart"></canvas>
        <p class="fst-italic font-monospace text-center mt-3">Total Number per Department</p>
    </div>
    <div class="col-md-8 mt-3">
        <canvas id="myChart1"></canvas>
        <p class="fst-italic font-monospace text-center">Total Number per Program</p>
    </div>
    <!-- End Card  -->

    <script>
    const ctx = document.getElementById('myChart');
    const ctx1 = document.getElementById('myChart1');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                label: 'Total ',
                data: [],
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

    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                labels: false,
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    display: false
                },
            }
        }
    });
    </script>

    <?php

  } else {

    $sql = "SELECT DISTINCT(p.Initials) FROM `research_information` r JOIN Program p ON r.Program=p.Course_Program;";
    $result = mysqli_query($con, $sql);

    $program_course = array();
    foreach ($result as $program) {
      $program_course[] = $program['Initials'];
    }

    if ($result->num_rows > 0) {

      for ($course = 0; $course < count($program_course); $course++) {

        $initials = $program_course[$course];
        $sql = "SELECT COUNT(p.Initials) AS 'Initials' FROM `research_information` r 
        JOIN Program p ON r.Program=p.Course_Program WHERE p.Initials = '$initials';";
        $result = mysqli_query($con, $sql);

        if ($row = $result->fetch_assoc()) {
          $Program[] = $row['Initials'];
        }
      }
    }

  ?>

    <div class="row m-0 p-0 rounded mt-4">
        <div class="col-md-4 bg-body shadow-sm pt-2 pb-2 rounded-start mx-0">
            <canvas id="myChart"></canvas>
            <p class="fst-italic font-monospace text-center mt-4 mb-0">Total Number per Department</p>
        </div>
        <div class="col-md-8 bg-body shadow-sm pt-3 pb-2 rounded-end mx-0">
            <canvas id="myChart1"></canvas>
            <p class="fst-italic font-monospace text-center mt-2 mb-0">Total Number per Program</p>
        </div>
    </div>
</div>

<!-- chart js data  -->
<script>
const ctx2 = document.getElementById('myChart');
const ctx3 = document.getElementById('myChart1');

new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($zoneDepartment); ?>,
        datasets: [{
            label: 'Total ',
            data: <?php echo json_encode($Zone); ?>,
            fill: true,
            backgroundColor: [
                'rgba(255, 159, 64, 0.4)',
                'rgba(54, 162, 235, 0.4)',
                'rgba(75, 192, 192, 0.4)',

                'rgba(255, 205, 86, 0.4)',
                'rgba(153, 102, 255, 0.4)',
                'rgba(75, 192, 87, 0.4)',
                'rgba(220, 20, 60, 0.4)',
                'rgba(247, 205, 50, 0.4)',

                'rgba(100, 149, 237, 0.4)',
                'rgba(199, 21, 133, 0.4)',
                'rgba(75, 192, 132, 0.4)',
                'rgba(147, 159, 64, 0.4)',
                'rgba(255, 159, 64, 0.4)',

                'rgba(54, 250, 235, 0.4)',
                'rgba(278, 99, 132, 0.4)',
                'rgba(260, 150, 132, 0.4)',
                'rgba(150, 68, 192, 0.4)',
                'rgba(100, 145, 154, 0.4)',

                'rgba(234, 159, 64, 0.4)',
                'rgba(135, 150, 87, 0.4)',
                'rgba(178, 167, 98, 0.4)',
                'rgba(255, 200, 64, 0.4)',
                'rgba(54, 243, 40, 0.4)',

            ],
        }]
    },
    options: {
        scales: {
            y: {
                grace: '5%',
                stacked: true,
                beginAtZero: true
            }
        },
        plugins: {
            tooltip: {
                enabled: true
            },
            legend: {
                position: 'bottom',
                display: true
            },
            // datalabels: {
            //   anchor: 'center',
            //   align: 'end',
            // offset: 5,
            // color: 'grey',
            // font: {
            //   weight: 'bold'
            // },
            // }
        }
    },
    // plugins: [ChartDataLabels],
});

new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($program_course) ?>,
        datasets: [{
            label: 'Total ',
            data: <?php echo json_encode($Program) ?>,
            fill: true,
            backgroundColor: [

                'rgba(255, 99, 132, 0.4)',
                'rgba(255, 159, 64, 0.4)',
                'rgba(54, 162, 235, 0.4)',
                'rgba(75, 192, 192, 0.4)',

                'rgba(255, 205, 86, 0.4)',
                'rgba(153, 102, 255, 0.4)',
                'rgba(75, 192, 87, 0.4)',
                'rgba(220, 20, 60, 0.4)',
                'rgba(247, 205, 50, 0.4)',

                'rgba(100, 149, 237, 0.4)',
                'rgba(199, 21, 133, 0.4)',
                'rgba(75, 192, 132, 0.4)',
                'rgba(147, 159, 64, 0.4)',
                'rgba(255, 159, 64, 0.4)',

                'rgba(54, 250, 235, 0.4)',
                'rgba(278, 99, 132, 0.4)',
                'rgba(260, 150, 132, 0.4)',
                'rgba(150, 68, 192, 0.4)',
                'rgba(100, 145, 154, 0.4)',

                'rgba(234, 159, 64, 0.4)',
                'rgba(135, 150, 87, 0.4)',
                'rgba(178, 167, 98, 0.4)',
                'rgba(255, 200, 64, 0.4)',
                'rgba(54, 243, 40, 0.4)',

            ],

        }]
    },
    options: {
        scales: {
            y: {
                grace: '5%',
                stacked: true,
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                display: false
            },
            datalabels: {
                color: 'red',
                anchor: 'end',
                align: 'end',
                offset: 5,
                color: 'white',
                font: {
                    weight: 'bold'
                },
            }
        }
    },
    // plugins: [ChartDataLabels],

});
</script>

<?php }; ?>