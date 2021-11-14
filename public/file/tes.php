<?php
$str = '<p>Stack Overflow is as frictionless and painless to use as we could make it.</p>
<p>jsjsjshsj</p>
<p>jsjej
lakaksksj</p>';
//$str = wordwrap($str, 28);
$str = explode("</p>", $str);
var_dump($str);
$str = $str[1] . '...';
echo $str;

?>