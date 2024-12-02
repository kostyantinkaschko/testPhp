<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
$startQuestions = [
    ["id" => false, "Question" => "Який двигун найкраще підходить для спортивної машини?", "answer" => "Бензиновий", "uncorrectVariants" => ["Дизельний", "Електричний", "Гібридний"], "QuestionType" => 0],
    ["id" => false, "Question" => "Як називається частина машини, що забезпечує її рух?", "answer" => "Двигун", "uncorrectVariants" => ["Колеса", "Кермо", "Кузов"], "QuestionType" => 0],
    ["id" => false, "Question" => "Що необхідно для забезпечення стабільної роботи автомобіля на дорозі?", "answer" => "Підвіска", "uncorrectVariants" => ["Фари", "Бампер", "Рульове керування"], "QuestionType" => 0],
    ["id" => false, "Question" => "Яка частина автомобіля відповідає за охолодження двигуна?", "answer" => "Радіатор", "uncorrectVariants" => ["Турбонаддув", "Вихлопна система", "Генератор"], "QuestionType" => 0],
    ["id" => false, "Question" => "Який тип трансмісії найбільш популярний у сучасних автомобілях?", "answer" => "Автоматична", "uncorrectVariants" => ["Механічна", "Полуавтоматична", "Ручна"], "QuestionType" => 0],
    ["id" => false, "Question" => "Який тип пального зазвичай використовують у автомобілях для міського циклу?", "answer" => "Бензин", "uncorrectVariants" => ["Дизель", "Електрика", "Газ"], "QuestionType" => 0],
    ["id" => false, "Question" => "Що необхідно змінювати для покращення потужності автомобіля?", "answer" => "Турбонаддув", "uncorrectVariants" => ["Колеса", "Акумулятор", "Гальма"], "QuestionType" => 0],
    ["id" => false, "Question" => "Яка частина машини допомагає зменшити її витрати пального?", "answer" => "Аеродинаміка", "uncorrectVariants" => ["Колеса", "Двигун", "Трансмісія"], "QuestionType" => 0],
    ["id" => false, "Question" => "Яка частина автомобіля забезпечує комфорт водія?", "answer" => "Підвіска", "uncorrectVariants" => ["Кермо", "Сидіння", "Трансмісія"], "QuestionType" => 0],
    ["id" => false, "Question" => "Яка технологія дозволяє зробити автомобіль більш екологічним?", "answer" => "Гібридні двигуни", "uncorrectVariants" => ["Звичайні бензинові двигуни", "Дизельні двигуни", "Електричні двигуни"], "QuestionType" => 0],
    ["id" => false, "Question" => "Як називається основна частина, яка відповідає за зв'язок автомобіля з дорогою?", "answer" => "Колеса", "uncorrectVariants" => ["Підвіска", "Кузов", "Двигун"], "QuestionType" => 0],
    ["id" => false, "Question" => "Який тип кузова зазвичай використовується для спортивних автомобілів?", "answer" => "Універсал", "uncorrectVariants" => ["Седан", "Універсал", "Хетчбек"], "QuestionType" => 0],
    ["id" => false, "Question" => "Яка система допомагає автомобілю зберігати стабільність при різких маневрах?", "answer" => "Контроль стабільності", "uncorrectVariants" => ["Гальмівна система", "Кермо", "Турбонаддув"], "QuestionType" => 0],
    ["id" => false, "Question" => "Які з цих частин машини є основними для забезпечення безпеки водія?", "answer" => ["Подушки безпеки", "Антиблокувальна система гальм", "Ремені безпеки"],  "uncorrectVariants" => ["Ксенонові фари", "Камера заднього виду"], "QuestionType" => 1]
];
foreach($startQuestions as $index => &$question) {
    $question["id"] = $index;
}
// print_r($startQuestions);
$questions = $startQuestions;
    

$questionsCount = 10;   
$counter = 0;

foreach ($questions as &$question) {
    if (!is_array($question["answer"])) {
        $question["uncorrectVariants"][] = $question["answer"];
    } else {
        $question["uncorrectVariants"] = array_merge($question["uncorrectVariants"], $question["answer"]);
    }
}


foreach ($questions as &$question) {
    shuffle($question["uncorrectVariants"]);
}

shuffle($questions);

unset($question);

$_SESSION["startQuestions"] = $startQuestions;
$_SESSION["questions"] = $questions;
$_SESSION["questionsCount"] = $questionsCount;
?>