<?php
include("./connections/connection.php");
include("./connections/global.php");
include("./connections/functions.php");


function recursiveLoop($count)
{
    // Base case: If count reaches 0, stop the recursion
    if ($count <= 0) {
        return;
    }

    // Print the current count
    echo 'Loop count: ' . $count . '<br>';

    // Recursive call with decreased count
    recursiveLoop($count - 1);
}

// Call the recursive function with an initial count of 10
recursiveLoop(25);
