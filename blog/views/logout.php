<?php
    require_once "../shared/header.php"; 

    session_destroy();
    header("Location: index.php");