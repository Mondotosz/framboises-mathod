<?php

/**
 * displays home view
 * @return void
 */
function home()
{
    require_once("view/home.php");
    viewHome();
}

/**
 * displays lost view
 * @return void
 */
function lost()
{
    require_once("view/lost.php");
    viewLost();
}

/**
 * displays forbidden view
 * @return void
 */
function forbidden()
{
    require_once("view/forbidden.php");
    viewForbidden();
}
