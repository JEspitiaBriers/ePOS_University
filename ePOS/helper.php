<?php

//data sanitisation
//string input check - type, length
//int - type, length
//floats ? 2dp?
//barcode input.  need to know what the input is

function sanitise($string, $connection){
    $str = mysqli_real_escape_string($connection, $string);//checks for any dangerous characters

    $str = htmlentities($string);//making sure all html code are safe by converting characters to entities

    return $string;//returns the clean string
}


function validateString($string, $minlength, $maxlength)//passes the string and its min/max length
{
    if (strlen($string)<$minlength)//if the length of string is lower than the min length
    {
        return "Minimum length: " . $minlength;
    }
    elseif (strlen($string)>$maxlength)//else if the length of string is higher than the max length
    {
        return "Maximum length: " . $maxlength;
    }
    return "";
}


function validateInt($int, $minNum, $maxNum)
{
    //creates an associative array of the options available
    $options = array("options" => array("min_range"=>$minNum,"max_range"=>$maxNum));

    if (!filter_var($int, FILTER_VALIDATE_INT, $options))
    {

        //isnt a valid number
        return "Not a valid number (must be whole and in the range: " . $minNum . " to " . $maxNum . ")";
    }
    return "";
}


function validatePrice($price)
{
    //creates an associative array of the options available
    $options = array("options" => array("min_range"=>$minNum,"max_range"=>$maxNum));

    if (!filter_var($int, FILTER_VALIDATE_INT, $options))
    {
        //isnt a valid number
        return "Not a valid number (must be whole and in the range: " . $minNum . " to " . $maxNum . ")";
    }
    return "";

    
}

function validateBarcode($barcodeInp){

    /*
        get input, check in database if the inputted num has a matching product. 
        if it does, its fine, if not, return failure

    */
    /*
        query SELECT * FROM 

    */


}


?>
