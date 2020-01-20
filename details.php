<?php
require_once 'load.php';

// test to see if it can get the id of each movie
// echo $_GET['id'];
// exit;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $tbl = 'tbl_movies';
    $col = 'movies_id';
    $getMovie = getSingleMovie($tbl, $col, $id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details</title>
</head>
<body>
    <?php include 'templates/header.php';?>

    <?php if(!is_string($getMovie)):?>
        <?php while($row = $getMovie->fetch(PDO::FETCH_ASSOC)):?>
            <img src="images/<?php echo $row['movies_cover'];?>" alt="<?php echo $row['movies_title']?>">
            <h2>Name: <?php echo $row['movies_title'];?></h2>
            <h4>Year: <?php echo $row['movies_year'];?></h4>
            <p>Story: <br> <?php echo $row['movies_storyline'];?></p>
            <a href="index.php">Back to Home</a>
        <?php endwhile;?>
    <?php endif;?>

    <?php include 'templates/footer.php';?>
</body>
</html>