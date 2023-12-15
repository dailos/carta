<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use App\Repositories\Fotos;
use App\Ficha;
use Carbon\Carbon;

class StoreFicha extends FormRequest
{
    protected $fotos;

    function __construct(Fotos $fotos) {
        $this->fotos = $fotos;
    }

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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validaciones adicionales para las fotos
            if ($this->has('fotos')) {
                $i = 0;
                foreach ($this->input('fotos') as $key => $value) {
                    $i++;
                    // Si tiene asignado id es que es una foto ya existente, lo ignoramos.
                    // Comprueba que se haya seleccionado fichero

                    if (!isset($value['id']) && !$this->hasFile('fotos.' . $key . '.fichero')) {

                        $validator->errors()->add('fotos', 'Compruebe que ha seleccionado un fichero para la foto ' . $i . '.');
                    }
                }
            }

            // Misma validación para croquis
            if ($this->has('croquis')) {
                foreach ($this->input('croquis') as $key => $value) {
                    // Si tiene asignado id es que es una foto ya existente, lo ignoramos.
                    // Comprueba que se haya seleccionado fichero
                    if (!isset($value['id']) && !$this->hasFile('croquis.' . $key . '.fichero')) {
                        $validator->errors()->add('croquis', 'Compruebe que ha seleccionado un fichero para el croquis ' . $key . '.');
                    }
                }
            }

        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @returhttps://tools.siteground.com/ftp?siteId=S1FuMFpIOE5KQT09n array
     */
    public function rules()
    {
        //dd($this->all());
        $rules = [
            'X' => 'required_with_all:Y,zona_UTM|nullable|numeric|between:100000,999999',
            'Y' => 'required_with_all:X,zona_UTM|nullable|numeric|between:0,10000000',
            'zona_UTM' => 'required_with_all:X,Y|nullable|numeric|between:1,60',
            'latitud' => 'nullable|between:-90,90',
            'longitud' => 'nullable|between:-180,180',
            'denominacion' => 'required|string|max:255',
            'isla_id' => 'required|exists:islas,id',
            'municipio_id' => 'required|exists:municipios,id',
            'localidad_id' => 'nullable|exists:localidads,id',
            'lugar' => 'string|nullable|max:255',
            'numero_dgph' => 'string|nullable|max:255',
            'actividad_id' => 'nullable|exists:actividads,id',
            'grupo_id' => 'nullable|exists:grupos,id',
            'tipo_id' => 'nullable|exists:tipos,id',
            'direccion' => 'string|nullable|max:100',
            'cod_postal' => 'string|nullable|max:20',
            'telefono' => 'string|nullable|max:50',
            'altitud' => 'nullable|integer',
            'toponimias' => 'string|nullable|max:100',
            'cartografia' => 'string|nullable|max:100',
            'obs_localizacion' => 'nullable',
            'fecha_construccion' => 'string|nullable|max:50',
            'antiguedad_id' => 'exists:antiguedads,id',
            'historia' => '',
            'superficie' => 'nullable|integer',
            'uso_actual_id' => 'nullable|exists:uso_actuals,id',
            'descripcion' => '',
            'dest_obras' => 'nullable',
            'saqueos' => 'nullable',
            'otras' => 'nullable',
            'alte_naturales' => 'nullable',
            'estado_id' => 'nullable|exists:estados,id',
            'fragilidad_id' => 'nullable|exists:fragilidads,id',
            'valor_cientifico_id' => 'nullable|exists:valor_cientificos,id',
            'obs_estado' => '',
            'documentacion' => '',
            'propiedad_id' => 'nullable|exists:propiedads,id',
            'declaracion_BIC' => 'nullable',
            'fecha_incoacion' => 'nullable|date_format:d/m/Y',
            'fecha_declaracion' => 'nullable|date_format:d/m/Y',
            'clasificacion_suelo_id' => 'nullable|exists:clasificacion_suelos,id',
            'calificacion_suelo_id' => 'nullable|exists:calificacion_suelos,id',
            'catalogo' => 'string|nullable|max:50',
            'nivel_proteccion' => 'nullable|numeric|between:0,9',
            'grado_proteccion_id' => 'nullable|exists:grado_proteccions,id',
            'intervenciones' => '',
            'sugerencias' => '',
            'obs_generales' => '',
            'fotos' => 'required|array|between:1,' . config('carta.maxFotos'),
            //'fotos.*.fichero' => 'image|mimes:jpeg,bmp,png',
            'croquis' => 'array|max:' . config('carta.maxCroquis'),
            //'croquis.*.fichero' => 'image|mimes:jpeg,bmp,png',
            'enlaces.*.texto' => 'string|nullable|max:255',
            'enlaces.*.url' => 'required|url|max:255',
            'multimedia.*.descripcion' => 'string|nullable|max:255',
            'multimedia.*.url' => 'required|url|max:255',
            'contactos.*.nombre' => 'string|nullable|max:255',
            'contactos.*.telefono' => 'string|nullable|max:255',
            'contactos.*.direccion' => 'string|nullable|max:255',
            'contactos.*.id_documento' => 'string|nullable|max:255',
            'contactos.*.email' => 'string|nullable|max:255',
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fotos.required' => 'Se requiere al menos una foto',
        ];
    }

    /**
     * Pre-procesa los datos enviados en el formulario.
     *
     * @return array
     */
    public function process(Ficha $ficha = null)
    {
        $validated = $this->validated();

        // Procesa fotos
        $fotos_array = ['fotos' => null, 'croquis' => null];

        if ($this->has('fotos')) {
            // Guarda las fotos
            $fotos_id = $this->fotos->save($validated['fotos']);
            $fotos_array['fotos'] = $fotos_id;
        }

        if ($this->has('croquis')) {
            // Guarda los croquis
            $croquis_id = $this->fotos->save($validated['croquis']);
            $fotos_array['croquis'] = $croquis_id;
            unset($validated['croquis']);
        }

        $validated['fotos'] = $fotos_array;

        // Reordena índices del array
        if ($this->has('enlaces')) {
            $validated['enlaces'] = index_sort($validated['enlaces'], true);
        }

        // Reordena índices del array
        if ($this->has('multimedia')) {
            $validated['multimedia'] = index_sort($validated['multimedia'], true);
        }

        // Reordena índices del array
        if ($this->has('contactos')) {
            foreach ($validated['contactos'] as $key => $value) {
                ($array = array_filter($value)) ? $validated['contactos'][$key] = $array : $validated['contactos'][$key] = null;
            }

            $contactos = index_sort(array_filter($validated['contactos']));

            if (empty($contactos)) {
                $validated['contactos'] = null;
            } else {
                $validated['contactos'] = $contactos;
            }
        }

        // Parsea las fechas
        if ($this->filled('fecha_incoacion')) {
            $validated['fecha_incoacion'] = Carbon::createFromFormat('d/m/Y', $validated['fecha_incoacion'])->format('Y-m-d');
        }

        if ($this->filled('fecha_declaracion')) {
            $validated['fecha_declaracion'] = Carbon::createFromFormat('d/m/Y', $validated['fecha_declaracion'])->format('Y-m-d');
        }

        if ($ficha) {

            // Comprueba si se eliminó alguna artibuto tipo select y checkbox

            $attributes = ['localidad_id', 'actividad_id', 'grupo_id', 'tipo_id', 'antiguedad_id', 'uso_actual_id', 'estado_id', 'fragilidad_id', 'valor_cientifico_id', 'propiedad_id', 'clasificacion_suelo_id', 'calificacion_suelo_id', 'grado_proteccion_id', 'enlaces', 'multimedia'];

            // Añade valor nulo a los atritubos eliminados
            foreach ($attributes as $attribute) {
                if ($ficha->getAttribute($attribute) != null && !$this->has($attribute)) {
                    $validated[$attribute] = null;
                }
            }

            $checkboxes = ['dest_obras', 'saqueos', 'otras', 'alte_naturales', 'declaracion_BIC'];

            foreach ($checkboxes as $checkbox) {
                if ($this->has($checkbox) && $this->input($checkbox) === "on") {
                    $validated[$checkbox] = true;
                } elseif ($ficha->getAttribute($checkbox) != null) {
                    $validated[$checkbox] = false;
                }
            }

        }

        return $validated;
    }
}
