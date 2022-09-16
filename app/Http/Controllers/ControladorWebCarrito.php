<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Carrito_producto;
use Session;

//Librerias de MercadoPago: (clases)
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

/* Including the constants.php file. */
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idcliente = Session::get("idcliente");
        /* Checking if the cart is empty or not. */
        if ($idcliente > 0) {
            $carrito = new Carrito();

            /* Checking if the cart is empty or not. */
            if ($carrito->obtenerPorCliente($idcliente) != null) {
                $carrito_producto = new Carrito_producto();
                if ($carrito_producto->obtenerPorCarrito($carrito->idcarrito) != null) {
                    $idcarrito = $carrito->idcarrito;
                    $aCarrito_productos = $carrito_producto->obtenerPorCarrito($idcarrito);
                } else {
                    $aCarrito_productos = array();
                }
            }
            /* Checking if the cart is empty or not. */ 
            else {
                $msg["estado"] = "info";
                $msg["mensaje"] = "Su carrito esta vacio, agregue productos desde Takeaway";
            }

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $pg = "carrito";
            return view("web.carrito", compact('pg', 'carrito', 'carrito_producto', 'aSucursales', 'aCarrito_productos'));
        }
    }  

    /* A function that is called when the user clicks on the "Finalizar Pedido" button. */
    public function finalizarPedido(Request $request){
        $pedido = new Pedido();
        $pedido->fecha = Date("Y-m-d H:i:s");
        $medioDePago =  $request->input('lstMedioDePago');

        $carrito_producto = new Carrito_producto();
        $aCarritoProductos = $carrito_producto->obtenerPorCliente(Session::get("idcliente"));

        foreach ($aCarritoProductos as $carrito) {
            $pedido->descripcion .= $carrito->producto . " - ";
            $pedido->total = $carrito->cantidad * $carrito->precio;
        }

        $pedido->fk_idsucursal = $request->input('lstSucursal');
        $pedido->fk_idcliente = Session::get("idcliente");

        if($medioDePago == "sucursal"){ //Si pago en sucursal va a pedido pendiente
            $pedido->fk_idestado = PEDIDO_PENDIENTE;
            $pedido->insertar();
            return redirect("/mi-cuenta");
        } else {
            $pedido->fk_idestado = PEDIDO_PENDIENTEDEPAGO;
            $pedido->insertar();
            return redirect("/mi-cuenta");
            //Abona por MercadoPago:
            $access_token = ""; //Lo dejamos vacio porque necesitamos que este preparado
            SDK::setClientId(config("payment-methods.mercadopago.client"));
            SDK::setClientSecret(config("payment-methods.mercadopago.secret"));
            SDK::setAccessToken($access_token); //Es el token de la cuenta de MP donde se deposita el dinero, como el cbu. 

            //Armado del producto ‘item’
            $item = new Item();
            $item->id = "1234";
            $item->title = "Burger SRL";
            $item->category_id = "products";
            $item->quantity = 1;
            $item->unit_price = $pedido->total; //El precio, que lo traemos del total
            $item->currency_id = "ARS"; //COP (la moneda del país)

            $preference = new Preference();
            $preference->items = array($item);

            //Datos del comprador:
            //Preparamos la pasarela de pago
            $payer = new Payer();
            $cliente = new Cliente(); //Obtenemos los datos de la BBDD
            $cliente->obtenerPorId(Session::get("idcliente"));
            $payer->name = $cliente->nombre;
            $payer->surname = $cliente->apellido;
            $payer->email = $cliente->correo;
            $payer->date_created = date('Y-m-d H:m:s');
            $payer->identification = array(
                "type" => "DNI", //Cedula de Ciudadania en Colombia
                "number" => $cliente->dni,
            );
            $preference->payer = $payer;

            //URL de configuración para indicarle a MP: (rutas)
            $preference->back_urls = [
                "success" => "http://127.0.0.1:8000/mercado-pago/aprobado/" . $cliente->idcliente, //Vamos a enviar e idcliente porque el pedido se inserta despues 
                "pending" => "http://127.0.0.1:8000/mercado-pago/pendiente/" . $cliente->idcliente, //Pago pendiente
                "failure" => "http://127.0.0.1:8000/mercado-pago/error/" . $cliente->idcliente, //Si dió error
            ];

            $preference->payment_methods = array("installments" => 6);
            $preference->auto_return = "all";
            $preference->notification_url = '';
            $preference->save(); //Ejecuta la transacción y lo envia a la pasarela de pago
        }

        //Vaciar el carrito
        // $carrito_producto->eliminarPorCliente(Session::get("idcliente"));

        $carrito = new Carrito();
        $carrito->eliminarPorCliente(Session::get("idcliente"));

        return redirect("/mi-cuenta");
    }

    public function eliminar(Request $request)
    {   
        $carrito_producto = new Carrito_producto();
        $carrito_producto->eliminar(Session::get("idproducto"));
         
        $carrito = new Carrito_producto();
        $carrito->eliminar(Session::get("idproducto"));

        return redirect("/carrito"); 

        
             
    //         else {
    //             $codigo = "ELIMINARPROFESIONAL";
    //             $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
    //         }
    //         echo json_encode($aResultado);
    //     } else {
    //         return redirect('admin/login');
    //     }
    // }   
    }
}
?>