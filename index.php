<?php include "db.php"; ?>
<?php 
  $sql = "SELECT * From table1";
  $query = mysqli_query($con,$sql);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>
    <div class = "container">
        <header>
            <h1>PHP Calculator</h1>
        </header>
        <div class="display">
            <ul>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <li class="output">
                    <span><?php echo $row['number1']; ?></span>
                    <span><?php echo $row['operator']; ?></span>
                    <span><?php echo $row['number2']; ?></span>
                    <span>=</span>
                    <span><?php echo $row['result']; ?></span>
                    <br>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="input">
            <form class = "" action = "process.php" method = "post">
                <input type="number" name="input1" placeholder="Enter Number">
                <input type="number" name="input2" placeholder="Enter Number">
                <select name="operator">
                  <option>+</option>
                  <option>-</option>
                  <option>*</option>
                  <option>/</option>
                  <option>%</option>
                </select>
                <input type = "submit" name = "submit" value ="Submit">
            </form>
        </div>
    </div>
</body>
</html>