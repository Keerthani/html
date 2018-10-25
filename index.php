<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>
  
<div class="container">
  <div class="row">
   
     <?php if (!empty($_POST)): ?>
     <div class="jumbotron text-center">
        <h1> Welcome, <?php echo htmlspecialchars($_POST["name"]); ?>!</h1>
        </div>

    <?php else: ?>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">

        <label for="loverage">Name of lovers: </label>
        <input type="text" class="form-control" id="email" name="name">

        <label for="loverage">Awesome Love age: </label>
        <input type="text" class="form-control" id="email" name="loverage">

        <label for="loosuage">loosu koddavi ponnu age: </label>
        <input type="text" class="form-control" id="email" name="loosuage">

        <hr/> <br>
        <input class="btn btn-primary" type="submit">
        </form>
    <?php endif; ?>

<?php





if(!empty($_POST)){
    $loverage = htmlspecialchars($_POST["loverage"]);
    $loosuage = htmlspecialchars($_POST["loosuage"]);

    $totalAge = $loverage + $loosuage;
 
for($i=0; $i<=$totalAge; $i++){
    echo "<div class='alert alert-success'><strong> $totalAge </strong> </div><br>";
}
}



?>

 /// MEEDUNUM SANTHIKUM VARAI UNKALIDAM IRUNTHU VIDAI PERUVATHU  NAAN  U NKAL  KO    
  K    oruka video va podan




</div>

</body>
</html>