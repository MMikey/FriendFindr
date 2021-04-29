<?php
/** @var mysqli $mysqli */

require_once "config.php";

class Validator
{

    static function validateUsername($username)
    {
        global $mysqli;
        //Validate username
        //here we check if the username field is empty or already taken
        //empty = checks if field is empty
        //trim = removes whitespace from beginning and end of string
        if (empty(trim($username))) {
            return "Please enter a username";
        } else {
            //prepare sql select statement
            //? is variable that will inserted as username
            $sql = "SELECT userid FROM users WHERE username = ?";

            //prepare = prepares a sql statement for execution.
            //Basically, will bind parameters to the question mark
            //then execute that statement
            if ($stmt = $mysqli->prepare($sql)) {
                //bind variable to prepared statement as parameters
                //this method also sanitised inputs, no sql injections...
                $stmt->bind_param("s", $param_username);

                //set the username parameter from the username input
                $param_username = trim($username);

                //attempt to execute statement
                if ($stmt->execute()) {
                    $stmt->store_result();

                    //check if there are rows from table that returns with same username
                    //i.e username already exists in table and user should try another one
                    if ($stmt->num_rows == 1) {
                        return "Username is already taken";
                    } else {
                        return true;
                    }
                } else // if statement can't be executed for whatever reason
                {
                    return "Oops something went wrong: " . $stmt->error;
                }
                $stmt->close();
            } else {
                return "Oops something went wrong: " . $mysqli->error;
            }
        }
    }

    static function validatePassword($password) {
        //Validate password
        //check password field is empty or less that 6 chars
        if (empty(trim($password))) {
            return "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            return "Password must have at least 6 characters.";
        } else {
            return true;
        }
    }

    static function validateConfirmPassword($password, $confirm_password) {
        if (empty(trim($confirm_password))) {
            return "Please confirm password!";
        } else {
            $confirm_password = trim($confirm_password);
            //check theres no password error and that the passwords match
            if (!empty($password) && ($password != $confirm_password)) {
                return "Password did not match.";
            }
            return true;
        }
    }

    static function validateEmail($email){
        global $mysqli;
        if (empty(trim($email))) {
            return "Please enter a valid email address";
        } else {
            $sql = "SELECT userid FROM users WHERE email = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_email);

                $param_email = trim($email);

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        return "This email is already taken";
                    } else {
                        return true;
                    }
                } else // if statement can't be executed for whatever reason
                {
                    return "Oops! Something went wrong. Please try again later. " . $mysqli->error;
                }
                $stmt->close();
            }
        }
    }

    static function validateBirthday($birthday) {
        if(!empty($birthday)) {
            $birthdate = strtotime($birthday);
            //31536000 is the number of seconds in a year
            if(time() - $birthdate < 18 * 31536000) {
                return "You must be 18 to join!";
            }else{
                return true;
            }
        } else {
            return "Please enter your birthdate!";
        }
    }

    static function validateHobby($userid, $hobby) {
        global $mysqli;
            $sql = "SELECT userid FROM userhobbies WHERE userid = $userid AND hobbyid=$hobby";
            if($result = $mysqli->query($sql)) {
                if($result->num_rows > 0) {
                    return "You're already part of this group..";
                }
                return true;
            } else {
                return "Oops! Something went wrong! $mysqli->error";
            }

    }

    static function validateJoinGroup($user_id, $group_id) {
        global $mysqli;
        $sql = "SELECT userid FROM usergroups WHERE userid = $user_id AND groupid=$group_id;";

        if($result = $mysqli->query($sql)) {
            if($result->num_rows > 0)
            {
                return "You're already part of this group..";
            }
            return true;
        } else {
            return "Oops! Something went wrong! $mysqli->error";
        }
    }
}