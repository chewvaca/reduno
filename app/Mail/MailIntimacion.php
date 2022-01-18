<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MailIntimacion extends Mailable
{
    use Queueable, SerializesModels;

    protected $cliente;
    protected $reclamo;
    protected $archivo;
    protected $request;
    // protected $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $data)
    {
        $this->request = $data;
        // var_dump(JSON_encode($data->cliente->NroCliente));
        // $this->cliente = $data->cliente;
        // $this->reclamo = $data->reclamo;
        // $this->archivo = $data->archivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('emails.intimacion')
            ->from(Auth::user()->email, 'RedUno SRL')
            ->with([
                'nCliente' => $this->request->input('cliente.NroCliente'),
                'cliente' => $this->request->input('cliente.Nombre'),
                'dni' => $this->request->input('cliente.DNI'),
                'direccion' => $this->request->input('cliente.Direccion'),
                'nContrato' => $this->request->input('cliente.NroContrato'),
                'email' => $this->request->input('cliente.EMail'),
                'telefono' => $this->request->input('cliente.Telefono'),
                'entidad' => $this->request->input('reclamo.Entidad'),
                'fecha' => $this->request->input('reclamo.Fecha'),
                'titulo' => $this->request->input('reclamo.Titulo'),
                'archivo' => $this->request->input('reclamo.Archivo'),
                'origen' => $this->request->input('reclamo.Origen')
            ]);
        if ($this->request->input('archivo.name'))
            $mail->attach(storage_path('app/'.$this->request->input('archivo.name')), [
                'as' => 'Intimacion.xml',
                'mime' => 'application/xml',
            ])
        ;
        return $mail;
    }
}
