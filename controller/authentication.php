<?php

/**
 * @brief handles login requests
 * @param array Expects $_POST with username and password
 * @return void
 */
function login($request)
{
    if (!isAuthenticated()) {
        if (empty($request)) {
            // shows login view
            require_once("view/login.php");
            viewLogin();
        } else {
            // check required inputs
            if (!empty($request["username"]) && isset($request["password"])) {
                try {
                    // Fetch user from the database
                    require_once("model/users.php");
                    $user = getUserByUsername($request["username"]);
                    // Check if user exists
                    if (!empty($user)) {
                        // Check if password matches
                        if (password_verify($request["password"], $user["password"])) {
                            createSession($request["username"]);
                            header("Location: /");
                        } else {
                            throw new Exception("Username and password do not match");
                        }
                    } else {
                        throw new Exception("Username and password do not match");
                    }
                } catch (Exception $e) {
                    // TODO cleaner error display for front end
                    echo $e->getMessage();
                }
            } else {
                // If missing required fields
                header("Location: /authentication/login");
            }
        }
    } else {
        // If already authenticated
        header("Location: /");
    }
}

/**
 * @brief handles register requests
 * @param array Expects $_POST with username, email, password and passwordCheck
 * @return void
 */
function register($request)
{
    if (!isAuthenticated()) {

        if (empty($request)) {
            // shows register view
            require_once("view/register.php");
            viewRegister();
        } else {
            // check required inputs
            if (!empty($request["username"]) && isset($request["email"]) && isset($request["password"]) && isset($request["passwordCheck"])) {
                try {

                    // validate email
                    if (!filter_var($request["email"], FILTER_VALIDATE_EMAIL)) {
                        throw new Exception("Invalid email format");
                    }

                    // password check
                    if ($request["password"] != $request["passwordCheck"]) {
                        throw new Exception("Password doesn't match");
                    }

                    require_once("model/users.php");
                    // check username availability
                    if (!empty(getUserByUsername($request["username"]))) {
                        throw new Exception("Username is already used");
                    }

                    // check email availability
                    if (!empty(getUserByEmail($request["email"]))) {
                        throw new Exception("Email is already used");
                    }

                    // add user
                    if (addUser($request["username"], $request["email"], password_hash($request["password"], PASSWORD_DEFAULT))) {
                        createSession($request["username"]);
                        header("Location: /");
                    } else {
                        throw new Exception("Unable to add user");
                    }
                } catch (Exception $e) {
                    // error handling
                    // TODO cleaner error on ui (export validation to a function and add ajax handling)
                    echo $e->getMessage();
                }
            } else {
                header("Location: /authentication/register");
            }
        }
    } else {
        header("Location: /");
    }
}

/**
 * @brief destroys user session and redirects to home
 * @return void
 */
function logout()
{
    session_destroy();
    header("Location: /");
}

/**
 * @brief create an user session
 * @param string username
 * @return void
 */
function createSession($username)
{
    $_SESSION["username"] = $username;
    // Get user's roles
    require_once("model/users_possesses_roles.php");
    $roles = getUserRoles($username);
    $_SESSION["roles"] = $roles;
}

/**
 * @brief checks if the user has an username in session
 * @return bool
 */
function isAuthenticated()
{
    $result = false;
    if (isset($_SESSION["username"])) {
        // Fetch user from the database
        require_once("model/users.php");
        $user = getUserByUsername($_SESSION["username"] ?? "");
        // Check if user exists
        if (!empty($user)) {
            $result = true;
        } else {
            // Remove username from the session variable since the user doesn't exist anymore
            unset($_SESSION["username"]);
        }
    }
    return $result;
}
