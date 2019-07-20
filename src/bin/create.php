<?php declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__ . "/../vendor/autoload.php";

$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . "/../"));
$loader->load('config.yml', 'yml');
$loader->load('src/App/Resources/config/services.yml', 'yml');

$app = $containerBuilder->get('app.random_image_generator');
$app->generate(200, 200);
