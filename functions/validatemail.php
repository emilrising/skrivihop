<?php

function check_email($addy, $return_mx_records = false) {
if (empty($addy)) return false;

if (!preg_match('/^[a-zA-Z0-9&\'\.\-_\+]+\@[a-zA-Z0-9.-]+\.+[a-zA-Z]{2,6}$/', $addy)) {
return false;
}

$mx_exists = false;
if (getmxrr(array_pop(explode('@', $addy)), $mx_records)) {
$mx_exists = true;
}

if ($mx_exists) {
return ($return_mx_records) ? $mx_records : true;
} else {
return false;
}
}

?>