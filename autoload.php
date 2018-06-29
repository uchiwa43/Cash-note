<?php
/**
 * Created by: Thomas DUPORT
 * Project: APEL
 * Date: 29/06/2018 21:53
 * Description:
 */

function my_autoloader($class) {
    include 'class/' . $class . '.php';
}
spl_autoload_register('my_autoloader');