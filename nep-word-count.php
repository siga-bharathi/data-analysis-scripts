<?php

$basedir = "../input-files";

$inputFile = fopen($basedir."/NEP.txt", "r") or die ("unable to open file");
$outputFile = fopen($basedir."/NEP-Word-Cloud.txt", "w") or die ("unable to open file");

$wordCount = array();

$wrdCount = 0;

$sightWords = array('a', 'and', 'away', 'big', 'blue', 'can', 'come', 'down', 'find', 'for', 'funny', 'go', 'help', 'here', 'i', 'in', 'is', 'it', 'jump', 'little', 'look', 'make', 'me', 'my', 'not', 'one', 'play', 'red', 'run', 'said', 'see','the', 'three', 'to', 'two', 'up', 'we', 'where', 'yellow', 'you', 'of', 'as', 'that', 'this', 'with', 'all', 'on', 'also', 'are', 'will', 'be', 'by', 'at', 'their', 'from', 'these', 'such', 'would', 'there' );

//read the input availability file and create a map
while (!feof($inputFile)) {
            
    $line = fgets($inputFile);

    if (empty ($line)){
        continue;
    }

    $line = str_replace(",", " ", $line);
    $line = str_replace("(", " ", $line);
    $line = str_replace(")", " ", $line);
    $line = str_replace(";", " ", $line);
    $line = str_replace("/", " ", $line);
    $line = str_replace(";", " ", $line);
    $line = str_replace(".", " ", $line);
    $line = str_replace("'", " ", $line);
    $line = str_replace("\'", " ", $line);
    $line = str_replace(":", " ", $line);
    $line = str_replace("-", " ", $line);

    $lineArr = explode(" ", $line);

    if (empty($lineArr)){
        continue;
    }

   
    foreach ($lineArr as $index => $word){
        

        if (is_numeric(trim($word))){
            //skip numbers
            continue;
        }

        if (empty(trim($word))){
            //skip blank spaces
            continue;
        }

        $wrdCount++;

        $lcWord = trim(strtolower($word));

        //$lcWord = rtrim($lcWord, 's');

        if (in_array($lcWord, $sightWords, false)){
            //skip is sight words
            continue;
        }

        if (strlen($lcWord) <=3){
            //skip up to letter words
            continue;
        }

        if (array_key_exists ($lcWord, $wordCount)) {
            $val = $wordCount[$lcWord] + 1;
            $wordCount[$lcWord] = $val;
        }else {
            $wordCount[$lcWord] = 1;
        }

  

    }
    
} //while

echo "word count => $wrdCount  <br>";

arsort($wordCount);

$outputStr = '';

foreach ($wordCount as $str => $count){

    $outputStr .= $str.",".$count."\n";

}

//write to insert command file
fwrite($outputFile, $outputStr);

?>