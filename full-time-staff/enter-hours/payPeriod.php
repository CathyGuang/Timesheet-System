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
        <div class="full-time-title">Pay Period Reminder
            <div class = "reminder_under_title">
                Timesheets need to be completed by Tuesday noon.
            </div>
        </div>
        
        <nav class="button-container"> 
        `<a href="../">`<button class="back-button">Back</button></a>
        <a href="/"><button class="home-button">Home</button></a>
        </nav>
    </div>


    <div class= "fulltime-form-container" >
            <div class = "purple_block">
                <div class = "today_date">
                    <div class = "dates_">
                        Today's Date is:
                        <div class = "the_date" id="date"></div>
                    </div>
                    <div id = "next_due_day" class = "dates_">
                        Next Due Day is:
                        <div class = "the_date" id="dueDate"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="js/payPeriod.js"></script>
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

    </div>


</body>
</html>