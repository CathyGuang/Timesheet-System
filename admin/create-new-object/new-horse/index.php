<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Admin | New Horse</title>
</head>

<body>

  <header>
    <h1>New Horse</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form autocomplete="off" action="create-new-horse.php" method="post" class="main-form">

    <p>Name:</p>
    <input type="text" name="name" value="" required>

    <p>Owner:</p>
    <label>(Leave blank if owner is this organization)</label>
    <input type="text" name="owner" value="">

    <p>FS Uses per Day:</p>
    <input type="number" name="org_uses_per_day" value="" required>

    <p>Owner Uses per Day:</p>
    <input type="number" name="owner_uses_per_day" value="" required>

    <p>Notes:</p>
    <input type="text" name="notes" value="">

    <br><br>
    <input type="submit" value="Create">

  </form>





</body>

</html>
