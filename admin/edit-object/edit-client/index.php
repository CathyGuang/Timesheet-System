<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Edit Client</title>
</head>

<body>

  <header>
    <h1>Edit Client</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form action="edit-client.php" method="post" class="main-form">

    <p>Name:</p>
    <input type="text" name="name" value="" required>

    <p>Email:</p>
    <input type="email" name="email" value="">

    <p>Phone Number:</p>
    <input type="number" name="phone" maxlength="10" value="">

    <br><br>
    <input type="submit" value="Create">

  </form>




</body>

</html>
