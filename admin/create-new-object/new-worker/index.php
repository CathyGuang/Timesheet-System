<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Admin | New Worker</title>
</head>

<body>

  <header>
    <h1>New Worker</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form action="create-new-worker.php" method="post" class="main-form">

    <p>Name:</p>
    <input type="text" name="name" value="" required>

    <p>Email:</p>
    <input type="email" name="email" value="">

    <p>Phone Number:</p>
    <input type="number" name="phone" maxlength="10" value="">

    <div>
      <p>Staff: <input type="checkbox" name="staff" value="TRUE"></p>
    </div>

    <div>
      <p>Volunteer: <input type="checkbox" name="volunteer" value="TRUE"></p>
    </div>

    <br><br>
    <input type="submit" value="Create">

  </form>





</body>

</html>
