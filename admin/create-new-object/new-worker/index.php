<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <title>Admin | New Worker</title>
</head>

<body>

  <header>
    <h1>New Worker</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form autocomplete="off" action="create-new-worker.php" method="post" class="standard-form">

    <p>Name:</p>
    <input type="text" name="name" value="" required>

    <p>Title:</p>
    <input type="text" name="title" value="">

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
    <button type="submit">Create</button>

  </form>





</body>

</html>
