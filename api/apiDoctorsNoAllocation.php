<?php
/**
 * Author: Joel
 * Date: 18/06/2020
 * Version: 1.0
 * Purpose: api for getting data from doctor that without allocation or researchproject
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "../class/Administrator.php";
$admin = new Administrator();
$doctors = $admin->doctorsWithoutAllocation();

echo json_encode($doctors);