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

  <div class="form-container">
    <form autocomplete="off" action="create-new-worker.php" method="post" class="standard-form">

      <div class="form-section">
        <div class="form-element">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" value="" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="title">Title:</label>
          <input type="text" name="title" id="title" value="">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" value="">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="phone">Phone Number:</label>
          <input type="number" name="phone" id="phone" maxlength="10" value="">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <p>Staff: <input type="checkbox" name="staff" value="TRUE"></p>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <p>Volunteer: <input type="checkbox" name="volunteer" value="TRUE"></p>
        </div>
      </div>

      <div class="form-section">
          <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
          <button type="submit">Create</button>
        </div>

    </form>
  </div>





</body>

</html>
