<?php
    $myName = "Jared Brannen";
    $headingName = "PHP Basics";
    $number1 = 7;
    $number2 = 13;
    $total = $number1 + $number2;
    $languages = ["PHP", "HTML", "JavaScript"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Basics</title>
</head>
<body>
    <h1><?php echo $headingName; ?></h1>
    <h2><?php echo $myName; ?></h2>
    <p>Number 1: <?php echo $number1 ?></p>
    <p>Number 2: <?php echo $number2 ?></p>
    <p>Total: <?php echo $total ?></p>

    <h3>List of Languages</h3>
    <ul id="languageList"></ul>
        <script>
            let languages = <?php echo json_encode($languages); ?>;
            let list = document.querySelector("#languageList");
            languages.forEach(lang => {
                let li = document.createElement("li");
                li.textContent = lang;
                list.appendChild(li);
            });
        </script>
</body>
</html>