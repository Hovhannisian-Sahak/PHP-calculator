<?php include "db.php"; ?>
<?php 
  $sql = "SELECT * FROM table1 ORDER BY id DESC LIMIT 5";
  $query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#calcForm').on('submit', function (e) {
                e.preventDefault();
                
                // Serialize the form data
                var formData = $(this).serialize();
                
                // Validate that the inputs are filled
                if (!$('input[name="input1"]').val() || !$('input[name="input2"]').val() || !$('select[name="operator"]').val()) {
                    alert("Please fill out all fields.");
                    return;
                }
                
                console.log("Form data:", formData);
                
                $.ajax({
                    url: 'process.php',
                    type: 'post',
                    data: formData,
                    success: function (response) {
                        console.log("Raw response from server:", response);
                        try {
                            var jsonData = JSON.parse(response);
                            console.log("Parsed JSON response:", jsonData);
                            if (jsonData.success == 1) {
                                window.location.href = 'index.php';
                            } else {
                                alert('Error: ' + jsonData.error);
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                            alert("Invalid response format. Please try again.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                        console.error("Response Text:", xhr.responseText); 
                        alert('Error processing request: ' + error);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
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
            <form id="calcForm" action="process.php" method="post">
                <input type="number" name="input1" placeholder="Enter Number" required>
                <input type="number" name="input2" placeholder="Enter Number" required>
                <select name="operator" required>
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="%">%</option>
                </select>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
