<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL válida.',
    'after'                => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => ':attribute debe ser una fecha igual o posterior a :date.',
    'alpha'                => ':attribute solo puede contener letras.',
    'alpha_dash'           => ':attribute solo puede contener letras, números, y guiones.',
    'alpha_num'            => ':attribute solo puede contener letras y números.',
    'array'                => ':attribute debe ser un array.',
    'before'               => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => ':attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'file'    => ':attribute debe estar entre :min y :max kilobytes.',
        'string'  => ':attribute debe estar entre :min y :max caracteres.',
        'array'   => ':attribute debe estar entre :min y :max items.',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => 'La confirmación de :attribute no coincide.',
    'date'                 => ':attribute no es un dato válido.',
    'date_format'          => ':attribute no cumple con el formato :format.',
    'different'            => ':attribute y :other debe ser diferentes.',
    'digits'               => ':attribute debe ser :digits digitos.',
    'digits_between'       => ':attribute debe estar entre :min y :max digitos.',
    'dimensions'           => ':attribute tiene unas dimensiones de imágen no válidas.',
    'distinct'             => ':attribute campo con valor duplicado.',
    'email'                => 'El campo :attribute debe ser un correo electrónico válido.',
    'exists'               => 'El :attribute seleccionado no es válido.',
    'file'                 => ':attribute debe ser un fichero.',
    'filled'               => 'El campo :attribute debe ser un valor .',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado no es válido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => ':attribute debe ser un integer.',
    'ip'                   => ':attribute debe ser una dirección IP válida.',
    'ipv4'                 => ':attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => ':attribute debe ser una dirección IPv6 válida.',
    'json'                 => ':attribute debe ser una sentencia JSON.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mayor de :max.',
        'file'    => ':attribute no puede ser mayor de :max kilobytes.',
        'string'  => ':attribute no puede ser mayor de :max caracteres.',
        'array'   => ':attribute no puede tener más de :max items.',
    ],
    'mimes'                => ':attribute debe ser un fichero de tipo: :values.',
    'mimetypes'            => ':attribute debe ser un fichero de tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute al menos debe ser de :min.',
        'file'    => ':attribute al menos debe ser de :min kilobytes.',
        'string'  => ':attribute al menos debe ser de :min caracteres.',
        'array'   => ':attribute al menos debe ser de :min items.',
    ],
    'not_in'               => 'El :attribute seleccionado no es válido.',
    'not_regex'            => 'El formato de :attribute no es válido.',
    'numeric'              => ':attribute debe ser un número.',
    'present'              => 'El campo de :attribute debe estar presente.',
    'regex'                => 'El formato de :attribute no es váido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo del :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo del :attribute es obligatorio a menos que  :other esté en :values.',
    'required_with'        => 'El campo de :attribute es obligatorio cuando  :values están presentes.',
    'required_with_all'    => 'El campo de :attribute es obligatorio cuando  :values están presentes.',
    'required_without'     => 'El campo de :attribute es obligatorio cuando  :values no están presentes.',
    'required_without_all' => 'El campo de :attribute es obligatorio cuando ninguno de los :values están presentes.',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => ':attribute debe pesar :size.',
        'file'    => ':attribute debe pesar :size kilobytes.',
        'string'  => ':attribute debe tener :size caracteres.',
        'array'   => ':attribute debe contener :size items.',
    ],
    'string'               => ':attribute dene ser una string.',
    'timezone'             => ':attribute debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido seleccionado.',
    'uploaded'             => ':attribute falló en la subida.',
    'url'                  => 'El formato de :attribute no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensaje personalizado',
        ],
        //Custom para las validaciones
        'name.*'    =>  [
            'required'  =>  'El nombre debe ser insertado para cada idioma'
        ],
        'email' => [
            'unique' => 'Este email ya está registrado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'username' => 'Nombre de usuario',
        'new_password' => 'Nueva contraseña',
        'cod_ficha' => 'Número de Ficha',
        'X' => 'X',
        'Y' => 'Y',
        'zona_UTM' => 'UTM Cuadrante',
        'denominacion' => 'Denominación',
        'isla_id' => 'Isla',
        'municipio_id' => 'Municipio',
        'localidad_id' => 'Localidad',
        'lugar' => 'Lugar',
        'numero_dgph' => 'Cod. Pat. Histórico',
        'actividad_id' => 'Actividad',
        'grupo_id' => 'Grupo',
        'tipo_id' => 'Tipo',
        'direccion' => 'Dirección',
        'cod_postal' => 'Cod. Postal',
        'telefono' => 'Teléfono',
        'altitud' => 'Altitud',
        'toponimias' => 'Toponimias',
        'cartografia' => 'Cartografía',
        'obs_localizacion' => 'Observaciones Localización',
        'fecha_construccion' => 'Fecha Construcción',
        'antiguedad_id' => 'Antigüedad',
        'historia' => 'Historia',
        'superficie' => 'Superficie',
        'uso_actual_id' => 'Uso actual',
        'descripcion' => 'Descripción',
        'estado_id' => 'Estado',
        'fragilidad_id' => 'Fragilidad',
        'valor_cientifico_id' => 'Valor Científico',
        'obs_estado' => 'Observaciones Estado',
        'documentacion' => 'Documentación',
        'propiedad_id' => 'Propiedad',
        'declaracion_BIC' => 'Declaración BIC',
        'fecha_incoacion' => 'Fecha Incoación',
        'fecha_declaracion' => 'Fecha Declaración',
        'clasificacion_suelo_id' => 'Clasificación Suelo',
        'calificacion_suelo_id' => 'Calificación Suelo',
        'catalogo' => 'Catálogo',
        'nivel_proteccion' => 'Nivel Protección',
        'grado_proteccion_id' => 'Grado Protección',
        'intervenciones' => 'Intervenciones',
        'sugerencias' => 'Sugerencias',
        'obs_generales' => 'Observaciones Generales',
    ],

];
