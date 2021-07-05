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
            <div class = "today_date">
            Today's Date is:
            <div id="date"></div>
            </div>
            <div class = "pay_table">
                <table class = "pay_table_fill">
                <tr class = "pay_table_row">
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Pay Date</th>
                </tr>
                <tr class = "pay_table_row">
                    <td>6/28/2021</td>
                    <td>7/11/2021</td>
                    <td>7/23/2021</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>7/26/2021</td>
                    <td>8/8/2021</td>
                    <td>8/20/2021</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>7/26/2021</td>
                    <td>8/8/2021</td>
                    <td>8/20/2021</td>
                </tr>
                <tr class = "pay_table_row">
                    <td>7/26/2021</td>
                    <td>8/8/2021</td>
                    <td>8/20/2021</td>
                </tr>
                </table>
            </div>
        </form>

    </div>


</body>
</html>