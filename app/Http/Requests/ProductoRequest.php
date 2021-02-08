<?php

namespace App\Http\Requests;

use App\Models\Producto;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'        => 'required|string|min:5|max:200',
            'precio'        => 'required|between:0,99999999999999.99',
            'descripcion'   => 'required|min:10|max:6000',
            'uso_id'        => 'required|integer',
            'categoria_id'  => 'required|integer',
            'estado_id'     => 'required|integer',
            "img"           => "required_without_all:imgup|array|min:1",
            "img.*"         => "required|image|distinct|mimes:jpg,bmp,png,jpeg,gif",
            "imgup"         => "required_without_all:img|array|min:1",
            "imgup.*"       => "required|integer",
        ];
    }
}
