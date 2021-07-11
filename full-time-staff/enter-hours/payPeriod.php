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
        </div>
        
        <nav class="button-container"> 
        <form>
        <input type="button"class="back-button" value="Back" onclick="history.back()">
        </form>
        <a href="/"><button class="home-button">Home</button></a>
        
        
        </nav>
    </div>


    <div class= "fulltime-form-container" >
            <div class = "purple_block">
                <div class = "reminder_under_title">
                    Timesheets need to be completed by Tuesday noon.
                </div>
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
            <div class = "purple_block" style = "margin-bottom: 100px;">
                <div class = "reminder_under_title">
                    Pay Periods and Pay Dates
                </div>
                <div class = "pay_table">

                <table class = "pay_table_fill">
                <tr class = "pay_table_row">
                    <th class ="pay_table_unit" >Start Date</th>
                    <th class ="pay_table_unit" >End Date</th>
                    <th class ="pay_table_unit" >Pay Date</th>
                </tr>
                <tr class = "pay_table_row">
                    <td class ="pay_table_unit"id = "-1_start_date"></td>
                    <td class ="pay_table_unit"id = "-1_end_date"></td>
                    <td class ="pay_table_unit"id = "-1_pay_date"></td>
                </tr>
                <tr class = "pay_table_row" style= "background-color:#b3def3;">
                    <td class ="pay_table_unit" style = "border: 2px solid #A0D2EB;" id = "1_start_date"></td>
                    <td class ="pay_table_unit" style = "border: 2px solid #A0D2EB;"id = "1_end_date"></td>
                    <td class ="pay_table_unit" style = "border: 2px solid #A0D2EB;"id = "1_pay_date"></td>
                </tr>
                <tr class = "pay_table_row">
                    <td class ="pay_table_unit"id = "2_start_date"></td>
                    <td class ="pay_table_unit"id = "2_end_date"></td>
                    <td class ="pay_table_unit"id = "2_pay_date"></td>
                </tr>
                <tr class = "pay_table_row">
                    <td class ="pay_table_unit"id = "3_start_date"></td>
                    <td class ="pay_table_unit"id = "3_end_date"></td>
                    <td class ="pay_table_unit"id = "3_pay_date"></td>
                </tr>
                <tr class = "pay_table_row">
                    <td class ="pay_table_unit"id = "4_start_date"></td>
                    <td class ="pay_table_unit"id = "4_end_date"></td>
                    <td class ="pay_table_unit"id = "4_pay_date"></td>
                </tr>
                <tr class = "pay_table_row">
                    <td class ="pay_table_unit"id = "5_start_date"></td>
                    <td class ="pay_table_unit"id = "5_end_date"></td>
                    <td class ="pay_table_unit"id = "5_pay_date"></td>
                </tr>
                </table>
            </div>

            </div>
            <script type="text/javascript" src="js/payPeriod.js"></script>

    </div>


</body>
</html>