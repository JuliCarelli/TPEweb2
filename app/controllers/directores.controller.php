<?php

require_once './app/models/peliculas.model.php';
require_once './app/views/directores.view.php';
require_once "./app/views/error.view.php";
require_once "./app/models/directores.model.php";

class DirectoresController{
    private $pelicula_model;
    private $model;
    private $view;

    public function __construct() {
        // verifico logueado
        // AuthHelper::verify();
        $this->pelicula_model = new PeliculasModel();
        $this->model = new DirectoresModel();
        $this->view = new DirectoresView();
    }

    public function show($params = null) {
        if(isset($params)){
            $director = $this->model->getById($params[0]);
            if($director){
                $this->view->showDirector($director);
            } else {
                ErrorView::displayError("Hubo un error: la director no se encuentra en la base");
            }
        } else {
            $directores = $this->model->getAll();
            $this->view->showDirectores($directores);
        }
        // obtengo tareas del controlador
        
        // muestro las tareas desde la vista
    }

    public function insert(){
        if(!empty($_POST["nombre"])){
            $this->model->insert($_POST);
            header("Location: ".BASE_URL);
        }
        else {
            // hubo un error
        }
    }

    public function update($id = null){
        if(isset($id) && !empty($_POST["nombre"]) ){
            $this->model->putById($id, $_POST);
        }

        header("Location: ".BASE_URL);
    }

    public function delete($id=null){
        if(isset($id)){
            $this->pelicula_model->deleteAllByDirectorId($id);
            $this->model->deleteById($id);
        }

        header("Location: ".BASE_URL);
    }

    public function showForm($params){
        if(isset($params[0])){
            $this->view->showForm($params[0]);
        } else {
            $this->view->showForm();
        }
    }
}
?>


