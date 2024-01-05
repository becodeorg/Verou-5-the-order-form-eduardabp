<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// We are going to use session variables so we need to enable sessions
session_start();

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

// TODO: provide some products (you may overwrite the example)
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
    // TODO: This function will send a list of invalid fields back
    return [];
}

function handleForm()
{
    // TODO: form related tasks (step 1)
         // Validation (step 2)
            $invalidFields = validate();
            global $products;
            $items = [];
            $address = "";
            if (!empty($invalidFields)) {
            } else {
        // TODO: handle successful submission
                $address = filter_input(INPUT_POST, "street") . " " . filter_input(INPUT_POST, "streetnumber") . "<br>" . filter_input(INPUT_POST, "city") . " " . filter_input(INPUT_POST, "zipcode");
                foreach ($products as $i => $product):
                    if (isset($_POST['products'][$i])) {
                        array_push($items, $product['name']);
                    }
                endforeach;
                echo "<h3>Your order is confirmed!</h3><br><h4>What you ordered: </h4><br><ul>";
                foreach ($items as $i => $item): 
                    echo "<li>" . $item . "</li>";
                endforeach;
                echo "</ul><h4>Your address:</h4><p>" . $address ."</p><br><h3>Thank you for shopping with us! See you in the future!</h3>";
    }}

// TODO: replace this if by an actual check for the form to be submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleForm();
}

require 'form-view.php';