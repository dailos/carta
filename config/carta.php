<?php

return [

   /*
    |--------------------------------------------------------------------------
    | Isla por defecto
    |--------------------------------------------------------------------------
    |
    | Este valor es el identificador de la isla por defecto. (Gran Canaria)
    |
    */
    'isla' => 3,

   /*
    |--------------------------------------------------------------------------
    | Ruta del fichero importación
    |--------------------------------------------------------------------------
    |
    | Ruta del fichero csv para importar las fichas
    |
    */
    'ImportFilePath' => env('IMPORT_FILEPATH', 'app/fichas.csv'),

    /*
     |--------------------------------------------------------------------------
     | Numero fichas CSV importación
     |--------------------------------------------------------------------------
     |
     | Número máximo de fichas que importar del fichero csv
     |
     */
     'maxCSVFichasImport' => env('MAX_CSV_IMPORT', 99999),

    /*
    |--------------------------------------------------------------------------
    | Banda UTM
    |--------------------------------------------------------------------------
    |
    | Banda geográfica por defecto para las coordenadas UTM de Canarias
    |
    */
    'bandaUTM' => 'R',

    /*
    |--------------------------------------------------------------------------
    | Maximo fotos
    |--------------------------------------------------------------------------
    |
    | Número máximo de fotos por ficha
    |
    */
    'maxFotos' => 3,

    /*
    |--------------------------------------------------------------------------
    | Máximo croquis
    |--------------------------------------------------------------------------
    |
    | Número máximo de croquis por ficha
    |
    */
    'maxCroquis' => 1,

    /*
    |--------------------------------------------------------------------------
    | Ruta old fotos
    |--------------------------------------------------------------------------
    |
    | Ruta de las fotos antiguas para migración
    |
    */
    'oldFotosUrl' => 'http://www.cartaetnograficagc.org/fotos/',

    /*
    |--------------------------------------------------------------------------
    | Ruta fotos
    |--------------------------------------------------------------------------
    |
    | Ruta donde se almacenan las fotos
    |
    */
    'fotoStoragePath' => 'photos',

    /*
    |--------------------------------------------------------------------------
    | Máximo de fichas para aviso
    |--------------------------------------------------------------------------
    |
    | Número de fichas que se pueden descargar por listado sin aviso
    |
    */
    'maxFichasDownloadWarning' => 100,

    /*
    |--------------------------------------------------------------------------
    | Modelos configurables
    |--------------------------------------------------------------------------
    |
    | Nombre de los modelos que se pueden modificar mediante el panel de
    | configuración admin.
    |
    */
    'configurable_models' => [
        'isla',
        'municipio',
        'localidad',
        'actividad',
        'grupo',
        'tipo',
        'antiguedad',
        'uso_actual',
        'estado',
        'fragilidad',
        'valor_cientifico',
        'propiedad',
        'clasificacion_suelo',
        'calificacion_suelo',
        'grado_proteccion',
    ],

    'coords_pico_nieves' => [
        'latitud' => 27.964417,
        'longitud' => -15.565772],

    /*
    |--------------------------------------------------------------------------
    | Zoom por defecto
    |--------------------------------------------------------------------------
    |
    | Grado de zoom para los mapas google
    |
    */
    'pdfZoom' => 15,

];