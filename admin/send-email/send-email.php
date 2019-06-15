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

    <?php var_dump($_POST); ?>


  </div>


</body>

</html>
