<?php

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
                    require_once("model/users.php");
                    $user = getUserByUsername($request["username"]);
                    if (!empty($user)) {
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
                    echo $e->getMessage();
                }
            } else {
                header("Location: /authentication/login");
            }
        }
    } else {
        header("Location: /");
    }
}

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

function logout()
{
    session_destroy();
    header("Location: /");
}

function createSession($username)
{
    $_SESSION["username"] = $username;
}

function isAuthenticated()
{
    return isset($_SESSION["username"]);
}
