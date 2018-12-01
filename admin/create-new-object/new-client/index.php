<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Admin | New Client</title>
</head>

<body>

  <header>
    <h1>New Client</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form action="create-new-client.php" method="post" class="main-form">

    <p>Name:</p>
    <input type="text" name="name" value="">

    <p>Email:</p>
    <input type="email" name="email" value="">

    <p>Phone Number:</p>
    <input type="tel" name="phone" value="">

    <br><br>
    <input type="submit" value="Create">

  </form>




</body>

</html>
