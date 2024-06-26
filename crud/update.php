<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";

use App\DB\MySQL\Methods\Update;
use App\Utils\Validation;

?>

<?php
$userID = intval($_GET["id"]);

if (!intval($userID = $_GET["id"])) {
    $errorMessage = "ID can't be empty";
    include $_SERVER["DOCUMENT_ROOT"] . "/crud/error.php";
    die();
}
?>

<main>
    <div class="container">
        <h2>Изменить пользователя</h2>
        <form action="update.php" method="POST" class="user-form">
            <input type="hidden" name="id" value="<?= $userID ?>">

            <div class="form-group">
                <label for="field">Поле для изменения</label>
                <select name="field" id="field">
                    <option value="email">Email</option>
                    <option value="name">Name</option>
                    <option value="age">Age</option>
                </select>
            </div>

            <div class="form-group">
                <label for="new_value">Новое значение</label>
                <input type="text" id="new_value" name="new_value" required>
            </div>

            <button type="submit" class="submit-btn">Изменить</button>
        </form>
    </div>
</main>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new Validation();

    $field = $_POST["field"];
    $value = $_POST["new_value"];
    $userID = intval($_POST["id"]);

    if ($field == "age") {
        $age = intval($value);

        $errors = $validator->validateForm(age: $age);
    }

    if ($field == "email") {
        $errors = $validator->validateForm(email: $value);
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            print "$error";
        }
    } else {
        $update = Update::getInstance();

        $updateUser = $update->updateUser(field: $field, filter: $userID, value: $value);

        if ($updateUser) {
            header("Location: index.php");
        } else {
            include $_SERVER["DOCUMENT_ROOT"] . "/crud/error.php";
            die();
        }
    }
}
?>


<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>
