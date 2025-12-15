<?php
session_start();
session_destroy();
header(header: "Location: ../public/login.php");