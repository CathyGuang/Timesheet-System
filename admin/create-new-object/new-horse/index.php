<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <title>Admin | New Horse</title>
</head>

<body>

  <header>
    <h1>New Horse</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class='form-container'>
    <form autocomplete="off" action="create-new-horse.php" method="post" class="standard-form">

      <div class='form-section'>
        <div class='form-element'>
          <label for="name">Horse Name:</label>
          <input type="text" name="name" id="name" value="" required>
        </div>
      </div>

      <div class='form-section'>
        <h3>Owner:</h3>
      </div>

      <div class='form-section'>
        <div class='form-element'>
          <label for="owner">Name: (Leave blank for organization)</label>
          <input type="text" name="owner" id="owner" value="">
        </div>

        <div class='form-element'>
          <label for="owner-email">Email:</label>
          <input type="email" name="owner-email" id="owner-email" value="">
        </div>

        <div class='form-element'>
          <label for="owner-phone">Phone:</label>
          <input type="phone" name="owner-phone" id="owner-phone" value="">
        </div>
      </div>

      <div class='form-section'>
        <h3>Veterinarian:</h3>
      </div>

      <div class='form-section'>
        <div class='form-element'>
          <label for="vet-name">Name:</label>
          <input type="text" name="vet-name" id="vet-name" value="">
        </div>

        <div class='form-element'>
          <label for="vet-email">Email:</label>
          <input type="email" name="vet-email" id="vet-email" value="">
        </div>

        <div class='form-element'>
          <label for="vet-phone">Phone:</label>
          <input type="phone" name="vet-phone" id="vet-phone" value="">
        </div>
      </div>

      <div class='form-section'>
        <h3>Use:</h3>
      </div>

      <div class='form-section'>
        <div class='form-element'>
          <label for="org_uses_per_day">Organization Uses per Day:</label>
          <input type="number" name="org_uses_per_day" id="org_uses_per_day" value="" required>
        </div>

        <div class='form-element'>
          <label for="owner_uses_per_day">Owner Uses per Day:</label>
          <input type="number" name="owner_uses_per_day" id="owner_uses_per_day" value="" required>
        </div>

        <div class='form-element'>
          <label for="horse_uses_per_week">Horse Uses per Week:</label>
          <input type="number" name="horse_uses_per_week" id="horse_uses_per_week" value="" required>
        </div>
      </div>

      <div class='form-section'>
        <div class='form-element'>
          <label for="notes">Notes:</label>
          <input type="text" name="notes" id="notes" value="">
        </div>
      </div>

      <div class='form-section'>
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Create</button>
      </div>

    </form>
  </div>





</body>

</html>
