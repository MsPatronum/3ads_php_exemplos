<?php
// Controlador

class HomeController
{    
    public function handleRequest($action)
    {
        switch ($action) {
            case 'index':
                $this->index();
                break;
        }
    }
    
    public function index()
    {
        $view = new HomeView();
        $view->showIndex();
    }
}
