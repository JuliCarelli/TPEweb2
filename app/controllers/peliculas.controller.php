<?php

require_once './app/models/peliculas.model.php';
require_once './app/views/peliculas.view.php';
require_once "./app/views/error.view.php";
require_once "./app/models/directores.model.php";

class PeliculasController{
    private $directores_model;
    private $model;
    private $view;

    public function __construct() {
        // verifico logueado
        // AuthHelper::verify();
        $this->directores_model = new DirectoresModel();
        $this->model = new PeliculasModel();
        $this->view = new PeliculasView();
    }

    public function show($params = null, $filtro = false) {
        if(isset($params)){
            $pelicula = $this->model->getById($params[0]);
            if($pelicula){
                $director = $this->directores_model->getById($pelicula->director);
                $pelicula->director = $director->nombre;
                $this->view->showPelicula($pelicula);
            } else {
                ErrorView::displayError("Hubo un error: la pelicula no se encuentra en la base");
            }
        } else {
            if($filtro){
                $peliculas = $this->model->getAllByDirector($filtro);
            } else {
                $peliculas = $this->model->getAll();
            }
            foreach($peliculas as $peli){
                $director = $this->directores_model->getById($peli->director);
                $peli->director = $director->nombre;
            }

            $directores = $this->directores_model->getAll();
            $this->view->showPeliculas($peliculas, $directores);
        }
        
    }

    public function insert(){
        if(!empty($_POST["titulo"] && !empty($_POST["genero"]) && !empty($_POST["year"]) && !empty($_POST["director"]))){
            $this->model->insert($_POST);
            header("Location: ".BASE_URL);
        }
        else {
            // hubo un error
        }
    }

    public function update($id = null){
        if(isset($id) && !empty($_POST["titulo"] && !empty($_POST["genero"]) && !empty($_POST["year"]) && !empty($_POST["director"])) ){
            $this->model->putById($id, $_POST);
        }

        header("Location: ".BASE_URL);
    }

    public function delete($id=null){
        if(isset($id)){
            $this->model->deleteById($id);
        }

        header("Location: ".BASE_URL);
    }

    public function showForm($params){
        $directores = $this->directores_model->getAll();

        if(isset($params[0])){
            $this->view->showForm($params[0],$directores);
        } else {
            $this->view->showForm(null, $directores);
        }
    }
}
?>


