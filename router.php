<?php
require_once './app/controllers/peliculas.controller.php';
require_once './app/controllers/directores.controller.php';
require_once './app/controllers/auth.controller.php';
require_once './app/helpers/auth.helper.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

function parseUrl($url){
    $params = explode("/", $url);

    $arrayReturn["action"] = $params[0] != "" ? $params[0] : "peliculas";
    $arrayReturn["filtro"] = isset($_GET["filtro"]) && $_GET["filtro"] != "" ? $_GET["filtro"] : false;
    $arrayReturn["method"] = $_SERVER["REQUEST_METHOD"];

    $arrayReturn["params"] = isset($params[1]) && $params[1] != "" ? array_slice($params, 1) : null;
    return $arrayReturn;
}

$action = $_GET["action"];
$action_array = parseUrl($action);

switch ($action_array["action"]) {

    case 'peliculas':
        $controller = new PeliculasController();
        switch ($action_array["method"]) {
            case 'GET':
                $controller->show($action_array["params"], $action_array["filtro"]);
                break;
            default:
                header("Location: peliculas");
                break;
        }
        break;
    case 'directores':
        $controller = new DirectoresController();
        switch ($action_array["method"]) {
            case 'GET':
                $controller->show($action_array["params"]);
                break;
            default:
                header("Location: peliculas");
                break;
        }
        break;
    case "deletePelicula":
        AuthHelper::verify();
        $controller = new PeliculasController();
        if (isset($action_array["params"])) {
            $controller->delete($action_array["params"][0]);
        } else {
            header("Location: " . BASE_URL);
        }
        break;
    case "deleteDirector":
        AuthHelper::verify();
        $controller = new DirectoresController();
        if (isset($action_array["params"])) {
            $controller->delete($action_array["params"][0]);
        } else {
            header("Location: " . BASE_URL);
        }
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'formPeliculas':
        AuthHelper::verify();
        $controller = new PeliculasController();

        switch ($action_array["method"]) {
            case 'GET':
                $controller->showForm($action_array["params"]);
                break;
            case "POST":
                if (isset($action_array["params"])) {
                    $controller->update($action_array["params"][0]);
                } else {
                    $controller->insert();
                }
                break;
            default:
                header("Location: peliculas");
                break;
        }
        break;
    case 'formDirectores':
        AuthHelper::verify();
        $controller = new DirectoresController();

        switch ($action_array["method"]) {
            case 'GET':
                $controller->showForm($action_array["params"]);
                break;
            case "POST":
                if (isset($action_array["params"])) {
                    $controller->update($action_array["params"][0]);
                } else {
                    $controller->insert();
                }
                break;
            default:
                header("Location: peliculas");
                break;
        }
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->auth();
        break;
    default:
        echo "404 Page Not Found";
        break;
}
