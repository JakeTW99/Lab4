<?php

$safePOST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sanitized_server = array_map('htmlspecialchars', $_SERVER);
$action = htmlspecialchars(filter_input(INPUT_POST, "action"));
$size_option = filter_input(INPUT_POST, 'size_option');
$size_price = 0.00;
$number_of_toppings = 0;
$toppings_multiplier = 0.00;

if ($action == "size_option"){
    
    if ($size_option == "small"){
        
        $size_price = 5.00;
        $toppings_multiplier = 0.50;
        
    } elseif ($size_option == "large") {
        
        $size_price = 9.00;
        $toppings_multiplier = 1.50;
        
    } else {
        
        $size_option = "medium";
        $size_price = 7.00;
        $toppings_multiplier = 1.00;
        
    }
}

if ($sanitized_server["REQUEST_METHOD"] == "POST" && isset($safePOST['toppings'])){
    
    $selectedToppings = $safePOST['toppings'];
    
    if (is_array($selectedToppings)) {
    
    $number_of_toppings = count($selectedToppings);
    }
}

$toppings_total = $number_of_toppings * $toppings_multiplier;
$grand_total = $size_price + $toppings_total;

?>

<!DOCTYPE html>
  <head>
      <meta charset="UTF-8">
      <title>Order Your Pizza</title>
  </head>
  <body>
      <h2>Pick the Size of your Pizza:</h2>
        <form action="index.php" method="post">
           <input type="radio" name="size_option" value="small">Small<br>
           <input type="radio" name="size_option" value="medium">Medium<br>
           <input type="radio" name="size_option" value="large">Large<br>
           <input type="hidden" name='action' value='size_option'/>
      <h2>Pick your Toppings:</h2>
          <input type="checkbox" name="toppings[]" value="pepperoni">Pepperoni<br>
          <input type="checkbox" name="toppings[]" value="sausage">Sausage<br>
          <input type="checkbox" name="toppings[]" value="mushrooms">Mushrooms<br>
          <input type="checkbox" name="toppings[]" value="extra_cheese">Extra Cheese<br>
          <input type="checkbox" name="toppings[]" value="bacon">Bacon<br>
          <input type="submit" value="Submit">
      </form>
      <br>
      <?php
        echo "Size picked: " . ucfirst($size_option);
        echo "<br>";
        echo "Cost of Pizza Size: $" . number_format($size_price, 2);
        echo "<br>";
        echo "Number of toppings picked: " . $number_of_toppings;
        echo "<br>";
        echo "Cost per Topping: $" . number_format($toppings_multiplier, 2);
        echo "<br>";
        echo "Calculating Cost: $" . number_format($size_price, 2) . " + (" . $number_of_toppings . " * $" . number_format($toppings_multiplier, 2) . ")";
        echo "<br>";
        echo "Total Cost of Pizza: $" . number_format($grand_total, 2);
      ?>
  </body>