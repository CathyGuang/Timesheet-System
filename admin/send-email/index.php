<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
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


    <form autocomplete="off" action="send-email.php"  class="standard-form" method="post">
      <P>To:</p>
      <input type="text" name="to" list="recipient-list" style="width:30vw;">
      <datalist id="recipient-list">
        <option value="Staff">
        <option value="Volunteers">
        <option value="Staff and Volunteers">
        <option value="Clients">
        <option value="Horse Owners">
        <option value="All">
      </datalist>

      <p>Subject:</p>
      <input type="text" name="subject" value="Subject" onclick="select();" style="width:30vw;">
      <p>Message</p>
      <textarea name="message" rows="20" cols="80"></textarea>

      <br><br>
      <input type="submit" value="Send">

    </form>




</body>

</html>
