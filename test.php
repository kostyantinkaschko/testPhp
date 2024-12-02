<?php
require_once "questions.php";

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/font.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/wrapper960.css">

    <title>Questions</title>
</head>

<body>
    <div class="wrapper">
        <form action="resultsProcessing.php" method="post">
            <?php foreach ($questions as $j => $question) {
                if ($counter < $questionsCount) {
                    $counter++;
                } else {
                    break;
                } ?>
                <h1><?= $question["Question"] ?></h1>
                <div class="answer">
                    <?php
                    if ($question["QuestionType"] === 0) {
                        foreach ($question["uncorrectVariants"] as $variant) { ?>
                            <input type="radio" name="userAnswer[<?= $j ?>]" value="<?= $variant ?>" required>
                            <p><?= $variant ?></p>
                        <?php }
                    } else if ($question["QuestionType"] === 1) {
                        foreach ($question["uncorrectVariants"] as $jj => $variant) { ?>
                                <input type="checkbox" name="userAnswer[<?= $j ?>][]" value="<?= $variant ?>">
                                <p><?= $variant ?></p>
                        <?php }
                    } ?>
                </div>
            <?php }
            var_dump($_SESSION["questionsCount"]); ?>
            <input type="submit">
        </form>
        <!-- <?php echo ("<pre>");
        print_r($_SESSION["startQuestions"]) ?>  -->
    </div>
    <script src="js/theme.js"></script>
</body>

</html>