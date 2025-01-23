<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Simple Calculator</h2>
    
    <?php
    $result = '';
    $error = '';
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get user input
        $num1 = filter_input(INPUT_POST, 'num1', FILTER_VALIDATE_FLOAT);
        $num2 = filter_input(INPUT_POST, 'num2', FILTER_VALIDATE_FLOAT);
        $operation = $_POST['operation'] ?? '';
        
        // Validate input
        if ($num1 === false || $num2 === false) {
            $error = "Please enter valid numbers";
        } else {
            // Perform calculation based on operation
            switch ($operation) {
                case 'add':
                    $result = $num1 + $num2;
                    break;
                case 'subtract':
                    $result = $num1 - $num2;
                    break;
                case 'multiply':
                    $result = $num1 * $num2;
                    break;
                case 'divide':
                    if ($num2 != 0) {
                        $result = $num1 / $num2;
                    } else {
                        $error = "Cannot divide by zero!";
                    }
                    break;
                default:
                    $error = "Please select a valid operation";
            }
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="num1">First Number:</label>
            <input type="number" name="num1" id="num1" step="any" required 
                value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>">
        </p>
        
        <p>
            <label for="operation">Operation:</label>
            <select name="operation" id="operation">
                <option value="" selected disabled hidden>Select Operator</option>
                <option value="add" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'add' ? 'selected' : ''; ?>>+</option>
                <option value="subtract" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'subtract' ? 'selected' : ''; ?>>-</option>
                <option value="multiply" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'multiply' ? 'selected' : ''; ?>>*</option>
                <option value="divide" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'divide' ? 'selected' : ''; ?>>/</option>
            </select>
        </p>
        
        <p>
            <label for="num2">Second Number:</label>
            <input type="number" name="num2" id="num2" step="any" required
                value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>">
        </p>
        
        <p>
            <input type="submit" value="Calculate">
        </p>
    </form>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($result !== ''): ?>
        <div class="result">
            Result: <?php echo htmlspecialchars($result); ?>
        </div>
    <?php endif; ?>

</body>
</html>