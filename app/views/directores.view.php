<?php

class DirectoresView {
    public function showDirectores($directores) {
        $count = count($directores);

        require './templates/directoresList.phtml';
    }

    public function showDirector($director) {

        require './templates/directorDetail.phtml';
    }
    public function showForm($id=null) {
        require './templates/formDirectores.phtml';
    } 

}