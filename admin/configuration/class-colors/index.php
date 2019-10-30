<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Admin | Class Colors</title>
</head>

<body>

  <header>
    <h1>Class Display Colors</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <form class="main-form small-form" action="colors.php" method="post">
      <div>
        <p>Class Type: </p>

        <p>Color: <input id="color-picker" type="color" name="color" value=""></p>
      </div>

    </form>

  </div>


</body>

</html>
