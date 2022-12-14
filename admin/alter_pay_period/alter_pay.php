<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Alter Pay Period | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Alter Pay Period</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" action="send-email.php"  class="standard-form" method="post">


    </form>
  </div>

  <script type="text/javascript" src="alter_pay.js"></script>


  
  <!-- DATALISTS -->
  <datalist id="recipient-list">
    <option value="Staff">
    <option value="Volunteers">
    <option value="Staff and Volunteers">
    <option value="Clients">
    <option value="Horse Owners">
    <option value="All">
  </datalist>




</body>

</html>