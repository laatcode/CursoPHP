<?php

namespace App\Controllers;

use Twig_Loader_Filesystem;
use App\Models\User;

class BaseController {

  protected $templateEngine;
  protected static $loggedUser = null;

  public function __construct() {
    // Clase que utiliza twig para cargar los archivos del sistema. Este método recibe como parametro, la ruta en la que se encuentran las vistas a utilizar.
    $loader = new Twig_Loader_Filesystem('app/views');

    // Permite almacenar la configuración de Twig
    $this->templateEngine = new \Twig_Environment($loader, [
      'debug' => true,
      'cache' => false
    ]);

    // Permite tomar una cadena y modificarla de cierta forma para usarla en el template.
    $this->templateEngine->addFilter(new \Twig_SimpleFilter('url', function ($path){
      return BASE_URL . $path;
    }));

    if (isset($_SESSION['userId'])) {
      self::$loggedUser = User::find($_SESSION['userId']);
    }

  }

  public function render($fileName, $data = []) {
    // El método render carga el template pasado como primer argumento y lo renderea con las variables pasadas como segundo argumento
    return $this->templateEngine->render($fileName, $data);
  }
}


 ?>
