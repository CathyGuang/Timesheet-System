<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Create Object</title>
</head>

<body>

  <header>
    <h1>Create Object</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <h3 class="main-content-header">Select type of object:</h3>

  <div class="main-content-div">
    <a href="new-worker"><button>Worker</button></a>
    <a href="new-client"><button>Client</button></a>
    <a href="new-horse"><button>Horse</button></a>
    <a href="new-other"><button>Other</button></a>

  </div>





</body>

</html>
