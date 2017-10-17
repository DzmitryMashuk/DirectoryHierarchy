<?php declare(strict_types=1);

 function printFile(string $file, int $deep, bool $cli ) : void
 {
    if ($cli) 
    {
		echo str_repeat("---", $deep) . $file . "\n";
    }
    else 
    {
        echo str_repeat('---', $deep) . $file . '<br>';
    }
    
}

function isCli() : bool
{
    return defined('STDIN') || (substr(PHP_SAPI, 0, 3) == 'cgi' && getenv('TERM'));
}

function readCurrentFile(string $currentDir) : array
{
    $odir = opendir($currentDir);

     while (($file = readdir($odir)) !== FALSE) 
     {
         $arrayFile[] = $file;
     }

     closedir($odir);

     return $arrayFile;
}

function scanDirectory(string $currentDir, int $deep, bool $cli) : void
{ 

    $arrayFile = readCurrentFile($currentDir);

    for ($i = 0; $i < count($arrayFile); $i++)
    {
        if ($arrayFile[$i] != FALSE && $arrayFile[$i] != '.' && $arrayFile[$i] != '..') 
        {
            printFile($arrayFile[$i], $deep, $cli);

            if (is_dir($currentDir.DIRECTORY_SEPARATOR.$arrayFile[$i]))
            {
                $deep ++;
                scanDirectory($currentDir.DIRECTORY_SEPARATOR.$arrayFile[$i], $deep, $cli);
                $deep --;
            }
        }
    }
}

$cli = isCli();
scanDirectory(__DIR__, 0, $cli);