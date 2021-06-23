<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <script src="https://kit.fontawesome.com/22bba2cae7.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.js"></script>
  <script type="text/javascript" src="js/rangeslider.min.js"></script>
  <script type="text/javascript" src="js/choices.js"></script>
  <link rel="stylesheet" href="css/slider.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/rangeslider.css">
  <link rel="stylesheet" href="css/added.css">
  <link rel="stylesheet" href="css/choices.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?> 
  <title>Pay Period Check</title>
</head>

<body class= "full-time-report" style="background-color:#D0BDF4;min-width:1226px;background-image: url('hor.png')">

    <div class="full-time-header">
        <p class="full-time-title">2021 Pay Period Form</p>
        <nav class="button-container"> 
        `<a href="../">`<button class="back-button">Back</button></a>
        <a href="/"><button class="home-button">Home</button></a>
        </nav>
    </div>

    <div class= "fulltime-form-container" >
        <form class="white-background" method="post" name="myform" id="myform" action="full-time.php">
            <div class = "pay_table">
                <table class = "table-fill">
                <tr class = "pay_table_row">
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Pay Date</th>
                </tr>
                <tr class = "pay_table_row">
                    <td>Peter</td>
                    <td>Griffin</td>
                    <td>$100</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>Lois</td>
                    <td>Griffin</td>
                    <td>$150</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>Joe</td>
                    <td>Swanson</td>
                    <td>$300</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>Cleveland</td>
                    <td>Brown</td>
                    <td>$250</td>
                </tr>
                </table>
            </div>
        </form>

    </div>


</body>
</html>