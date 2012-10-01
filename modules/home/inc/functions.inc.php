<?php
function generatekey($length)
{
$options = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$code = "";
for($i = 0; $i < $length; $i++)
{
$key = rand(0, strlen($options) - 1);
$code .= $options[$key];
}

return $code;
}
?>