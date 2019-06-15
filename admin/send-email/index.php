<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Email | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Send System Email</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <form action="send-email.php" method="post">
      <input type="text" name="from" value="<?php echo $organizationName; ?> Scheduling System">
      <input type="text" name="to" list="recipient-list">
      <datalist id="recipient-list">
        <option value="Staff">
        <option value="Volunteers">
        <option value="Staff and Volunteers">
        <option value="Clients">
      </datalist>

      <input type="text" name="subject" value="Subject" onclick="select();">

      <input type="textarea" name="message" rows="15" cols="20">

    </form>

  </div>


</body>

</html>
