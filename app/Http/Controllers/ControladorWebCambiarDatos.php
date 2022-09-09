<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use Session;

class ControladorWebCambiarDatos extends Controller
{
    public function index()
    {
        $pg = "cambiar-datos";

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $cliente = new Cliente();
        $cliente->obtenerPorId(Session::get('idcliente'));

        return view("web.cambiar-datos", compact('pg', 'aSucursales', 'cliente'));
    
    }

    public function editar(Request $request){
        $cliente = new Cliente();
        $cliente->obtenerPorId(Session::get('idcliente'));
       
        $pg = "cambiar-datos";
        
        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $correo = $request->input('txtCorreo');
        $dni = $request->input('txtDni');
        $celular = $request->input('txtCelular');
        $clave = $request->input('txtClave');
        
       
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        
        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->correo = $correo;
        $cliente->dni = $dni;
        $cliente->celular = $celular;
        $cliente->guardar();
       $msg["estado"]= "success";
       $msg["msg"]= "cambiado correctamente";
        
         return view ("web.mi-cuenta", compact('msg', 'aSucursales', 'pg', 'cliente'));
    }
        
        
   
}