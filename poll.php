<?php
// Poll with PHP

// Get the input from the user
$question = $_POST["question"];
$option1 = $_POST["option1"];
$option2 = $_POST["option2"];
$option3 = $_POST["option3"];
$option4 = $_POST["option4"];
$vote = $_POST["vote"];

// Create an array to store the votes
$votes = array($option1 => 0, $option2 => 0, $option3 => 0, $option4 => 0);

// Read the votes from a file
$filename = "votes.txt";
if (file_exists($filename)) {
  $file = fopen($filename, "r");
  while (!feof($file)) {
    $line = fgets($file);
    list($key, $value) = explode("=", $line);
    if (isset($votes[$key])) {
      $votes[$key] = intval($value);
    }
  }
  fclose($file);
}

// Update the votes with the user input
if (isset($votes[$vote])) {
  $votes[$vote]++;
}

// Write the votes to the file
$file = fopen($filename, "w");
foreach ($votes as $key => $value) {
  fwrite($file, $key . "=" . $value . "\n");
}
fclose($file);

// Calculate the total votes and the percentages
$total = array_sum($votes);
$percentages = array();
foreach ($votes as $key => $value) {
  $percentages[$key] = round(($value / $total) * 100);
}

// Display the question and the options
echo "<h1>" . $question . "</h1>";
echo "<form method='post'>";
echo "<input type='radio' name='vote' value='" . $option1 . "'>" . $option1 . "<br>";
echo "<input type='radio' name='vote' value='" . $option2 . "'>" . $option2 . "<br>";
echo "<input type='radio' name='vote' value='" . $option3 . "'>" . $option3 . "<br>";
echo "<input type='radio' name='vote' value='" . $option4 . "'>" . $option4 . "<br>";
echo "<input type='submit' value='Vote'>";
echo "</form>";

// Display the results as a bar chart
echo "<h2>Results:</h2>";
echo "<table>";
foreach ($percentages as $key => $value) {
  echo "<tr>";
  echo "<td>" . $key . "</td>";
  echo "<td><img src='bar.png' width='" . $value * 4 . "' height='20'></td>";
  echo "<td>" . $value . "%</td>";
  echo "</tr>";
}
echo "</table>";

?>
