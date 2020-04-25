<?php
require_once __DIR__.'/classes/DAO/EventDAO.php';
require_once __DIR__.'/classes/DAO/UserDAO.php';
require_once __DIR__.'/classes/Application.php';
require_once __DIR__.'/classes/Form/RegisterForm.php';
require_once __DIR__.'/classes/Form/LoginForm.php';
require_once __DIR__.'/classes/Form/NewEventForm.php';
require_once __DIR__.'/classes/Form/EditEventForm.php';

/**
 * Parámetros de conexión a la BD
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'yovoy_DB');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

/**
 * Función para autocargar clases PHP.
 *
 * @see http://www.php-fig.org/psr/psr-4/
 */
spl_autoload_register(function ($class) {
    
    // project-specific namespace prefix
    $prefix = 'es\\ucm\\fdi\\aw\\';
    
    // base directory for the namespace prefix
    $base_dir = __DIR__;
    
    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    
    // get the relative class name
    $relative_class = substr($class, $len);
    
    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Inicializa la aplicación
$app = es\ucm\fdi\aw\Application::getSingleton();
$app->init(array('host'=>DB_HOST, 'db'=>DB_NAME, 'user'=>DB_USER, 'pass'=>DB_PASS));

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function(array($app, 'shutdown'));
