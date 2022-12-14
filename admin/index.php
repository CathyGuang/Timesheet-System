<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Admin Page</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <a href="create-new-object"><button class="green-button">Create new Person/Object</button></a>
    <a href="reports"><button class="blue-button">Generate Report</button></a>
    <a href="edit-object"><button class="red-button">Edit Object</button></a>
    <a href="system-email"><button class="blue-button">System Email</button></a>
    <a href="send-email"><button class="blue-button">Send Email</button></a>
    <!-- <a href="alter_pay_period"><button class="blue-button">Alter Pay Period</button></a> -->
  </div>

  <form autocomplete="off" action="editable-daily-schedule/" method="post" id="editable-daily-schedule-form" style="visibility: hidden">
    <input type="text" name="selected-name" value="ALL">
  </form>


</body>

</html>
