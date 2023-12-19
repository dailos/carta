<?php

namespace App\Exporters;

use App\Ficha;
use Illuminate\Support\Collection;

class FichasCSVExporter
{


    public function export(Collection $collection)
    {
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename=fichas.csv');
        $fp = fopen('php://output', 'w');
        fputcsv($fp, $this->getHeader(), ";");
        foreach ($collection as $ficha){
            fputcsv($fp, $this->getFichaContent($ficha), ";");
        }
        fclose($fp);
    }

    /**
     * @return string[]
     */
    private function getHeader() : array
    {
        return  ['Código', 'X', 'Y', 'Zona UTM', 'X Pico Nieves', 'Y Poco Nieves', 'Latitud', 'Longitud',
            'Denominación', 'Isla', 'Municipio', 'Localidad', 'Lugar', 'Número dgph', 'Actividad', 'Grupo',
            'Tipo', 'Dirección', 'Código Postal', 'Teléfono', 'Altitud', 'Toponimias', 'Cartografía', 'Observaciones Localización',
            'Fechas Construcción', 'Antiguedad', 'Historia', 'Superficie', 'Uso Actual', 'Descripción', 'Destrucción Obras',
            'Saqueos', 'Otras', 'Alteración Natural', 'Estado', 'Fragilidad', 'Valor Científico', 'Observación Estado',
            'Documentación', 'Propiedad', 'Declaración BIC', 'Fecha Incoación', 'Fechas Declaración', 'Clasificación Suelo',
            'Calificación Suelo', 'Catálogo', 'Nivel Protección', 'Grado Protección', 'Intervenciones', 'Sugerencias',
            'Observaciones Generales', 'Fotos', 'Enlaces', 'Multimedia', 'Contactos', 'Creada', 'Actualizada'
        ];
    }

    /**
     * @param Ficha $ficha
     * @return array
     */
    private function getFichaContent(Ficha $ficha) : array
    {

        return [
            $ficha->cod_ficha,
            $ficha->X,
            $ficha->Y,
            $ficha->zona_UTM,
            $ficha->Xpiconieves,
            $ficha->Ypiconieves,
            $ficha->latitud,
            $ficha->longitud,
            $ficha->denominacion,
            $ficha->isla_id ? $ficha->isla->nombre : "",
            $ficha->municipio_id ? $ficha->municipio->nombre : "",
            $ficha->localidad_id ? $ficha->localidad->nombre : "",
            $ficha->lugar,
            $ficha->numero_dgph,
            $ficha->actividad_id ? $ficha->actividad->nombre : "",
            $ficha->grupo_id ? $ficha->grupo->nombre : "",
            $ficha->tipo_id ? $ficha->tipo->nombre : "",
            $ficha->direccion,
            $ficha->cod_postal,
            $ficha->telefono,
            $ficha->altitud,
            $ficha->toponimias,
            $ficha->cartografia,
            $ficha->obs_localizacion,
            $ficha->fecha_construccion,
            $ficha->antiguedad_id ? $ficha->antiguedad->nombre: "",
            $ficha->historia,
            $ficha->superficie,
            $ficha->uso_actual_id ? $ficha->uso_actual->nombre : "",
            $ficha->descripcion,
            $this->resolveBool($ficha->dest_obras),
            $this->resolveBool($ficha->saqueos),
            $this->resolveBool($ficha->otras),
            $this->resolveBool($ficha->alte_naturales),
            $ficha->estado_id ? $ficha->estado->nombre : "",
            $ficha->fragilidad_id ? $ficha->fragilidad->nombre : "",
            $ficha->valor_cientifico_id ? $ficha->valor_cientifico->nombre : "",
            $ficha->obs_estado,
            $ficha->documentacion,
            $ficha->propiedad_id ? $ficha->propiedad->nombre : "",
            $this->resolveBool($ficha->declaracion_BIC),
            $ficha->fecha_incoacion,
            $ficha->fecha_declaracion,
            $ficha->clasificacion_suelo_id ? $ficha->clasificacion_suelo->nombre: "",
            $ficha->calificacion_suelo ? $ficha->calificacion_suelo->nombre: "",
            $ficha->catalogo,
            $ficha->nivel_proteccion,
            $ficha->grado_proteccion_id ? $ficha->grado_proteccion->nombre : "",
            $ficha->intervenciones,
            $ficha->sugerencias,
            json_encode($ficha->fotos),
            json_encode($ficha->enlaces),
            json_encode($ficha->multimedia),
            json_encode($ficha->contactos)
        ];
    }

    /**
     * @param bool $value
     * @return string
     */
    private function resolveBool(bool $value = null) : string
    {
        if(is_null($value)){
            return "";
        }
        return $value ? 'Sí' : 'No';
    }
}
