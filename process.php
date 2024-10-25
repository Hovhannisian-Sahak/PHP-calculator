<?php
include "db.php";

if (
    isset($_POST['input1']) && $_POST['input1'] &&
    isset($_POST['input2']) && $_POST['input2'] &&
    isset($_POST['operator']) && $_POST['operator']
) {
    $number1 = $_POST['input1'];
    $number2 = $_POST['input2'];
    $operator = $_POST['operator'];

    // Perform calculations
    switch ($operator) {
        case '+':
            $result = $number1 + $number2;
            break;
        case '-':
            $result = $number1 - $number2;
            break;
        case '*':
            $result = $number1 * $number2;
            break;
        case '/':
            $result = ($number2 != 0) ? $number1 / $number2 : "Undefined";
            break;
        case '%':
            $result = ($number2 != 0) ? $number1 % $number2 : "Undefined";
            break;
        default:
            echo json_encode(["success" => 0, "error" => "Please select a valid operator."]);
            exit;
    }

    // Insert calculation into the database
    $sql = "INSERT INTO table1 (number1, operator, number2, result) VALUES ($number1, '$operator', $number2, '$result')";
    if (!mysqli_query($con, $sql)) {
        error_log("Database error: " . mysqli_error($con));
        echo json_encode(["success" => 0, "error" => "Error: " . mysqli_error($con)]);
        exit;
    }

    // Log success and send response
    error_log("Calculation saved successfully: $number1 $operator $number2 = $result");
    echo json_encode(["success" => 1, "message" => "Calculation saved successfully."]);
    exit;
} else {
    // If 'submit' is not set, return an error
    echo json_encode(["success" => 0, "error" => "No calculation submitted."]);
    exit;
}
?>
