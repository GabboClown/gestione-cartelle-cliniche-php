<?php
    foreach($_COOKIE as $key => $value){
        setcookie($key, NULL, time() - 1000, "/");
    }
    header("Location: ../login.html");