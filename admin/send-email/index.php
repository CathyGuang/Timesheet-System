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


    <form action="send-email.php"  class="small-form" method="post">
      <input type="text" name="from" value="<?php echo $organizationName; ?> Scheduling System" onclick="select();">
      <input type="text" name="to" list="recipient-list">
      <datalist id="recipient-list">
        <option value="Staff">
        <option value="Volunteers">
        <option value="Staff and Volunteers">
        <option value="Clients">
        <option value="All">
      </datalist>

      <input type="text" name="subject" value="Subject" onclick="select();">

      <textarea name="message" rows="30" cols="30"></textarea>

    </form>




</body>

</html>
