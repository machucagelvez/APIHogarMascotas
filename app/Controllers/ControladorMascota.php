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
        $nombre = $this->request->getPost('nombre');
        $edad = $this->request->getPost('edad');
        $tipo = $this->request->getPost('tipo');
        $descripcion = $this->request->getPost('descripcion');
        $comida = $this->request->getPost('comida');

        $datosAgregar = [
            'nombre'=>$nombre,
            'edad'=>$edad,
            'tipo'=>$tipo,
            'descripcion'=>$descripcion,
            'comida'=>$comida
        ];

        if ($this->validate('verificarEntradas')) {
            $this->model->insert($datosAgregar);
            $mensaje = array('estado'=>true,'mensaje'=>"Registro agregado con éxito");
            return $this->respond($mensaje);
        }else {
            $validation = \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);
        }
    }

    public function editarMascota($id)
    {
        $datosActuales = $this->request->getRawInput();
        $datosEditar = [
            'nombre'=>$datosActuales['nombre'],
            'edad'=>$datosActuales['edad'],
            'tipo'=>$datosActuales['tipo'],
            'descripcion'=>$datosActuales['descripcion'],
            'comida'=>$datosActuales['comida']
        ];
        if ($this->validate('verificarEntradas')) {
            $this->model->update($id, $datosEditar);
            $mensaje = array('estado'=>true,'mensaje'=>"Registro editado con éxito");
            return $this->respond($mensaje);
        } else {
            $validation = \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);
        }
        
    }

    public function borrarMascota($id)
    {
        $consulta = $this->model->where('id', $id)->delete();
        $filasAfectadas = $consulta->connID->affected_rows;
        if ($filasAfectadas==1) {
            $mensaje = array('estado'=>true,'mensaje'=>"Registro eliminado con éxito");
            return $this->respond($mensaje);
        } else {
            $mensaje = array('estado'=>false,'mensaje'=>"No fue posible eliminar el registro");
            return $this->respond($mensaje,400);
        }
        
    }

    public function buscarMascota($id)
    {
        if ($this->model->find($id)) {
            return $this->respond($this->model->find($id));
        } else {
            $mensaje = array('estado'=>false,'mensaje'=>"La mascota con id número ".$id." no está registrada");
            return $this->respond($mensaje,400);
        }
        
        
    }

}