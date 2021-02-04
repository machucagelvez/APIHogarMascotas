<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ControladorMascota extends ResourceController
{
    protected $modelName = 'App\Models\ModeloMascota';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function agregarMascota()
    {
        //$id = $this->resquest->getPost('id');
        $nombre = $this->request->getPost('nombre');
        $edad = $this->request->getPost('edad');
        $tipo = $this->request->getPost('tipo');
        $descripcion = $this->request->getPost('descripcion');
        $comida = $this->request->getPost('comida');

        $datosAgregar = [
            //'id'=>$id,
            'nombre'=>$nombre,
            'edad'=>$edad,
            'tipo'=>$tipo,
            'descripcion'=>$descripcion,
            'comida'=>$comida
        ];

        if ($this->validate('verificarEntradas')) {
            $this->model->insert($datosAgregar);
            $mensaje = array('estado'=>true,'mensaje'=>"Registro agregado con exito");
            return $this->respond($mensaje);
        }else {
            $validation = \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);
        }
    }
}