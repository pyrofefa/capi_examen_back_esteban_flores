<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DateTime;

class UserController extends Controller
{
    protected $message   = null;
    protected $status     = 'success';
    protected $data = [];

    public function index()
    {
        $now = new DateTime();
        try {
            $results = User::where('id','>',0)->with('domicilio')->get();
            foreach ($results as $key => $value) {
                $array = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'fecha_nacimento' => $value['fecha_nacimento'],
                    'edad' => date_diff($now, new DateTime($value['fecha_nacimento']))->format("%y"),
                    'domicilio' => $value['domicilio']
                ];
                array_push($this->data, $array);
            }
        }catch (\Exception $e){
            $this->status   =   "error";
            $this->message   =  "¡¡Ha ocurrido un pequeño error, favor de intentarlo más tarde!";
        }
        return response()->json([
            'status'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->data,
        ]);

    }
}