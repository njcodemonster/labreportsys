<?php
/* Create a file to calculate hash of */
//file_put_contents('example.txt', 'The quick brown fox jumped over the lazy dog.');
//echo hash_file('md5', 'example.txt');



//$myfile = fopen("example.txt", "r") or die("Unable to open file!");
//echo fread($myfile,filesize("example.txt"));
//fclose($myfile);

echo hash_file('md5', 'example.txt');
echo "<br>".hash_file('md5', 'example1.txt');

?>

