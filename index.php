<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// We are going to use session variables so we need to enable sessions
session_start();

$user_street = ($_POST["street"]) ?? $_SESSION["user_street"];
$user_streetnumber = ($_POST["streetnumber"]) ?? $_SESSION["user_streetnumber"];
$user_city = ($_POST["city"]) ?? $_SESSION["user_city"];
$user_zipcode = ($_POST["zipcode"]) ?? $_SESSION["user_zipcode"];

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

$products = [
    ['name' => 'Sonic Screwdriver', 'price' => 399.99],
    ['name' => 'Self-lacing Shoes', 'price' => 249.99],
    ['name' => 'Proton Pack', 'price' => 99.99],
    ['name' => 'What-If Machine', 'price' => 799.99],
    ['name' => 'Tricorder', 'price' => 149.99],
    ['name' => 'Point-of-View Gun', 'price' => 129.99],
    ['name' => 'Neuralyzer', 'price' => 549.99],
    ['name' => 'Carbonite Freezing', 'price' => 499.99],
];

$totalValue = 0;

function validate()
{
    $fields = ["email", "street", "streetnumber", "city", "zipcode"];
    $incorrectFields = [];
    foreach ($fields as $i => $field): 
        $input = filter_input(INPUT_POST, $field);
        if (empty($input)) {
            array_push($incorrectFields, $field . " is required");
        }
    endforeach;
    $email = filter_input(INPUT_POST, "email");
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        array_push($incorrectFields, "email is not in a valid format");
    }
    $zipcode = filter_input(INPUT_POST, "zipcode");
    if (!is_numeric($zipcode) && !empty($zipcode)) {
        array_push($incorrectFields, "zipcode is not in a valid format");
    }
    return $incorrectFields;
}

function handleForm()
{
    $errorMessages = validate();
    global $products;
    $items = [];
    foreach ($products as $i => $product):
        if (isset($_POST['products'][$i])) {
            array_push($items, $product['name']);
        }
    endforeach;
        if (empty($items)) {
            echo "<div class='alert alert-warning' role='alert'><h3>Time paradox detected!</h3><br><p>You didn't select any items. Go grab your TARDIS and do some shopping!</p></div>";
        } elseif (!empty($errorMessages)) {
            echo "<div class='alert alert-warning' role='alert'><h3>Replicator detected! Please correct the following fields: </h3><ul>";
            foreach ($errorMessages as $i => $error):
                echo "<li>" . $error . "</li>";
            endforeach;
            echo "</ul></div>";
        } else {
        // TODO: handle successful submission
            $address = filter_input(INPUT_POST, "street") . " " . filter_input(INPUT_POST, "streetnumber") . "<br>" . filter_input(INPUT_POST, "city") . " " . filter_input(INPUT_POST, "zipcode");
            echo "<div class='alert alert-success' role='alert'><h3>Your order is confirmed!</h3><br><h4>What you ordered: </h4><ul>";
            foreach ($items as $i => $item): 
                echo "<li>" . $item . "</li>";
            endforeach;
            echo "</ul><h4>Your address:</h4><p>" . $address ."</p><br><h3>Thank you for shopping with us! See you in the future!</h3></div>";
        }}

// TODO: replace this if by an actual check for the form to be submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleForm();
    $_SESSION["user_street"] = filter_var($_POST["street"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $_SESSION["user_streetnumber"] = filter_var($_POST["streetnumber"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $_SESSION["user_city"] = filter_var($_POST["city"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $_SESSION["user_zipcode"] = filter_var($_POST["zipcode"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

require 'form-view.php';