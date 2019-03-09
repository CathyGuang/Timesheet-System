<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
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
    <a href="create-new-event"><button class="green-button">Create new Class/Shift</button></a>
    <a href="create-new-object"><button class="green-button">Create new Person/Object</button></a>
    <a href="reports"><button class="blue-button">Generate Report</button></a>
    <a href="edit-event"><button class="red-button">Edit/Remove Class/Shift</button></a>
    <a href="edit-object"><button class="red-button">Edit/Remove Object</button></a>
    <a href="configuration"><button class="blue-button">Configuration</button></a>

  </div>


</body>

</html>
