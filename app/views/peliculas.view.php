<?php

class PeliculasView {
    public function showPeliculas($peliculas, $directores) {
        require './templates/peliculasList.phtml';
    }
    public function showPelicula($pelicula) {

        require './templates/peliculaDetail.phtml';
    }
    public function showForm($id=null, $directores) {
        require './templates/formPeliculas.phtml';
    }
}