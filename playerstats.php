<?php
$id = intval($_REQUEST["id"]);
include 'conn.php';
include 'functions.php';

echo printStats($id);
