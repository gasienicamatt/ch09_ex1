<?php
//set default values
$name = '';
$email = '';
$phone = '';
$message = 'Enter some data and click on the Submit button.';

//process
$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'process_data':
        //sanitize and get data
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone');

        //initiate error message, in case of any errors this will display instead of the results
        $errorMsg = "";

        //name variables for later
        $firstName = "";
        $lastName = "";

        //phone variables for later
        $part1 ="";
        $part2 ="";
        $part3 ="";

        //trim the right and left spaces
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);

        //I found this code online. I wanted a way to remove any special characters like dashes
        //From the input, so the user doesn't have to reinput the number if they formatted it
        //this only preserves numbers
        $phone = preg_replace('/[^0-9]/', '', $phone);

        /*************************************************
         * validate and process the name
         ************************************************/
        // 1. make sure the user enters a name
        // 2. display the name with only the first letter capitalized

        //check if the name field is empty
        if (!empty($name))
        {
            //capitalize each separate word
            $name = ucwords($name);

            //check for spaces
            $i = strpos($name, " ");

            //if there's at least one space, get first and last names
            //if there are more it treats every word after the first one as a
            //part of the last name and displays it all
            if ($i !== false)
            {
                    $firstName = substr($name, 0, $i);
                    $lastName = substr($name, $i + 1);
            }
            else
            {
                $firstName = $name;
            }
        }
        else
        {
            //when empty add an error message
            $errorMsg .="ERROR: Missing name\n";
        }
        /*************************************************
         * validate and process the email address
         ************************************************/
        // 1. make sure the user enters an email
        // 2. make sure the email address has at least one @ sign and one dot character

        //check if the string is empty
        if (!empty($email))
        {
            //if it isn't empty check for missing characters
            if (strpos($email, "@")===FALSE || strpos($email, ".")===FALSE)
            {
                //error message for missing characters
                $errorMsg .= "ERROR: Email is missing '@' or a '.'\n";
            }
        }
        else
        {
            //when empty add an error message
            $errorMsg .= "ERROR: Missing email\n";
        }
        /*************************************************
         * validate and process the phone number
         ************************************************/
        // 1. make sure the user enters at least seven digits, not including formatting characters
        // 2. format the phone number like this 123-4567 or this 123-456-7890
        if (!empty($phone))
        {
            //check if the string has 7 or more digits
            if (strlen($phone) >= 7)
            {
                //if it's exactly 7 draw a shortened number format
                if (strlen($phone) == 7)
                {
                    $part1 = substr($phone, 0, 3);
                    $part2 = substr($phone, 3, 3);
                    $phone = "$part1-$part2";
                }
                //otherwise draw regular formatting
                else
                {
                    $part1 = substr($phone, 0, 3);
                    $part2 = substr($phone, 3, 3);
                    $part3 = substr($phone, 6);
                    $phone = "$part1-$part2-$part3";
                }
            }
            else
            {
                //when the phone number is less than 7 charcaters long add this error msg
                $errorMsg .= "ERROR: Phone number is too short\n";
            }
        }
        else
        {
            //when empty add an error message
            $errorMsg .= "ERROR: Missing phone number\n";
        }
        /*************************************************
         * Display the validation message
         ************************************************/

        //display the full message
        if (empty($errorMsg)) {
            $message = "Hello $firstName,\n\n" .
                "Thank you for entering this data:\n\n" .
                "Name: $firstName $lastName\n" .
                "Email: $email\n" .
                "Phone: $phone\n";
        }
        //if there are any error messages display them instead of the normal message
        else
        {
            $message = $errorMsg;
        }

        break;
}
include 'string_tester.php';
?>