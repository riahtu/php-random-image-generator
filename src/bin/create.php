<?php declare(strict_types=1);

use App\RandomImageGenerator;
use App\Utils\Color;
use App\Utils\OutputHandler;
use App\Utils\SaveHandler;
use Symfony\Component\Filesystem\Filesystem;

require_once __DIR__ . DIRECTORY_SEPARATOR
    . ".." . DIRECTORY_SEPARATOR
    . "vendor" . DIRECTORY_SEPARATOR
    . "autoload.php";

// Variables
$outputPrefix = Color::LCyan. "<"
    . Color::LBlue . "["
    . Color::Cyan
    . (new \DateTime())->format('H:i:s')
    . Color::LBlue . "]"
    . Color::LCyan . "> "
    . Color::White;

$outputSuffix = "";
$basePath = __DIR__ . DIRECTORY_SEPARATOR
    . ".." . DIRECTORY_SEPARATOR
    . ".." . DIRECTORY_SEPARATOR
    . "out";

// Vendor Dependencies
$fs = new Filesystem();

// Dependencies
$oh = new OutputHandler($outputPrefix, $outputSuffix);
$sh = new SaveHandler($fs, $basePath);


// Run project
$randomImageGenerator = new RandomImageGenerator($oh, $sh);
$randomImageGenerator->generate(200, 200);
