<?php
/**
 * Author: Joel
 * Date: 25/05/2020
 * Version: 1.0
 * Purpose: api for updating ward
 */

session_start();

include_once "../class/Ward.php";

if (isset($_SESSION['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $ward = new Ward();
    $ward->update($id, $name, $location, $capacity);
}