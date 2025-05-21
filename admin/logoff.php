<?php
include('../config/base.php');

session_start();
session_destroy();

header("Location: " . BASE_ADMIN . 'login.php');