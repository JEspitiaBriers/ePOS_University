<?php

    function sanitise($str, $connection)
    {
        $str = mysqli_real_escape_string($connection, $str);
        $str = htmlentities($str);
        return $str;
    }

    function validateString($a, $minlength, $maxlength)
    {
        if (strlen($a)<$minlength)
        {
            // wasn't a valid length, return a help message:
            return "Minimum length: " . $minlength;
        }
        elseif (strlen($a)>$maxlength)
        {
            // wasn't a valid length, return a help message:
            return "Maximum length: " . $maxlength;
        }
        // data was valid, return an empty string:
        return "";
    }

    function validateInt($a, $min, $max)
    {
        // see PHP manual for more info on the options: http://php.net/manual/en/function.filter-var.php
        $options = array("options" => array("min_range"=>$min,"max_range"=>$max));

        if (!filter_var($a, FILTER_VALIDATE_INT, $options))
        {
            // wasn't a valid integer, return a help message:
            return "Not a valid number (must be whole and in the range: " . $min . " to " . $max . ")";
        }
        // data was valid, return an empty string:
        return "";
    }

    function validateEmail($a)
    {
        // Remove all illegal characters from email
        $a = filter_var($a, FILTER_SANITIZE_EMAIL);
        // Check to see if the email address conforms to the expected format
        if (filter_var($a, FILTER_VALIDATE_EMAIL)) {
            // data was valid, return an empty string:
            return "";
        }
        else {
            return " Email address is not valid ";
        }

    }
    // all other validation functions should follow the same rule:
    // if the data is valid return an empty string, if the data is invalid return a help message
?>