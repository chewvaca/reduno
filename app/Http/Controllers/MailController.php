<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Intimacion;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailIntimacion;
use App\Models\Archivo;

class MailController extends Controller
{
    //
    public function get(Request $request)
    {
        $cliente = Cliente::select('cliente_id as NroCliente', 'nombre as Nombre', 'dni as DNI', 'direccion as Direccion', 'email as EMail', 'telefono as Telefono', 'contratos.id as NroContrato')
            ->leftJoin('localizaciones', 'clientes.id', '=', 'localizaciones.cliente_id')
            ->leftJoin('contratos', 'contratos.localizacion_id', '=', 'localizaciones.id')
            ->where('pppoe', '=', $request->pppoe)
            ->first();
        return response()->json($cliente);
    }
    public function store(Request $request)
    {
        // return $request;
        // return $request->input('archivo.createStamp');
        // return Archivo::where('created_at','=',$request->input('archivo.createStamp'))->first()->id;
        if($request->input('archivo.createStamp'))
        $archivo = Archivo::where('created_at', '=', $request->input('archivo.createStamp'))->first()->id;
        else
        $archivo = null;

        Mail::to($request->input('cliente.EMail'))
            ->send(new MailIntimacion($request));
        Intimacion::create([
            'contrato_id' => $request->input('cliente.NroContrato'),
            'archivo_id' => $archivo
        ]);
    }
}
