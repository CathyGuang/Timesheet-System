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


    <form action="send-email.php"  class="full-page-form" method="post">
      <p>From:</p>
      <input type="text" name="from" value="<?php echo $organizationName; ?> Scheduling System" onclick="select();">
      <P>To:</p>
      <input type="text" name="to" list="recipient-list">
      <datalist id="recipient-list">
        <option value="Staff">
        <option value="Volunteers">
        <option value="Staff and Volunteers">
        <option value="Clients">
        <option value="All">
      </datalist>

      <p>Subject:</p>
      <input type="text" name="subject" value="Subject" onclick="select();">
      <p>Message</p>
      <textarea name="message" rows="20" cols="70"></textarea>

      <input type="submit" value="Send">

    </form>




</body>

</html>
