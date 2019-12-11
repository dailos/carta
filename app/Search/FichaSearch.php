<?php

namespace App\Search;

use Illuminate\Database\Eloquent\Builder;
use App\Ficha;
use App\Maps\GeoDistance;
use App\Maps\PointLocation;

class FichaSearch
{
    /**
     * Aplica los filtros para la búsqueda
     *
     * @param  array $filters
     * @param  int  $perPage
     * @param  string  $path
     */
    public static function apply($filters, $perPage = null, $path = null)
    {
        if (isset($filters['query'])) {
            // Crear query de búsqueda
            $query = (new Ficha)->newQuery();

            // Añadir los join y el where de búsqueda
            self::addJoinsWhere($query, $filters);

            // Añadir al where los filtros
            self::addModelFilters($query, $filters);
        } else {
            $query = (new Ficha)->newQuery();

            // Añadir al where los filtros
            self::addModelFilters($query, $filters);
        }

        // Comprobar si es búsqueda paginada
        if ($perPage != null) {
            $fichas = $query->paginate($perPage);

            if ($path) {
                $fichas->withPath($path);
            }
        } else {
            $fichas = $query->get();
        }

        return $fichas;
    }

    /**
     * Aplica búsqueda en area circular
     *
     * @param  int  $lat
     * @param  int  $lon
     * @param  int  $radio
     * @param  int  $perPage
     * @param  string  $path
     */
    public static function applyCircleArea($lat, $lon, $radio, $perPage = null, $path = null)
    {
        return self::applyArea('circle', compact('lat', 'lon', 'radio'), $perPage, $path);
    }

    /**
     * Aplica búsqueda en el area de un polígono
     *
     * @param  array  $points  Vértices del polígono
     * @param  int  $perPage
     * @param  string  $path
     */
    public static function applyPolygonArea($points, $perPage = null, $path = null)
    {
        return self::applyArea('polygon', compact('points'), $perPage, $path);
    }

    /**
     * Aplica búsqueda en las cercanías de una línea con varios segmentos (polyline)
     *
     * @param  array  $points puntos de la linea
     * @param  int  $offset máxmina distancia a la linea, en metros
     * @param  int  $perPage
     * @param  string  $path
     */
    public static function applyPolyLine($points, $offset, $perPage = null, $path = null)
    {
        return self::applyArea('polyline', compact('points', 'offset'), $perPage, $path);
    }

    /**
     * Realiza la búsqueda en area determinada.
     * @param  string $type  tipo de área
     * @param  $params  parámetros de búsqueda
     * @param  int  $perPage
     * @param  string  $path
     */
    private static function applyArea($type, $params, $perPage, $path)
    {
        $fichas = Ficha::all();

        $ids = array();

        // Obtiene los ids de las fichas dentro del area de búsqueda
        foreach ($fichas as $ficha) {
            if ($ficha->latitud && $ficha->longitud) {
                switch ($type) {
                    case 'polygon':
                        $point = $ficha->longitud . " " . $ficha->latitud;

                        // Comprobar si está dentro del area del polígono
                        $pointLocation = new PointLocation();
                        $location = $pointLocation->pointInPolygon($point, $params['points']);

                        if ($location !== "outside") {
                            array_push($ids, $ficha->id);
                        }
                        break;
                    case 'polyline':
                        $point = array(['lat' => $ficha->latitud, 'lon' => $ficha->longitud]);

                        // Comprobar si está cerca de algún segmento del polyline
                        $distance = GeoDistance::getGeoDistancePointToPolyline($params['points'], $point);

                        if ($distance <= $params['offset']) {
                            array_push($ids, $ficha->id);
                        }
                        break;
                    case 'circle':
                        // Obtener distancia entre las coordenadas de búsqueda y las coordenadas de la ficha, en metros
                        $distance = GeoDistance::getGeoDistancePointToPoint($params['lat'], $params['lon'], $ficha->latitud, $ficha->longitud);

                        if ($distance <= $params['radio']) {
                            array_push($ids, $ficha->id);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }

        $fichasQuery = Ficha::whereIn('id', $ids);

        // Comprobar si es búsqueda paginada
        if ($perPage != null) {
            $fichas = $fichasQuery->paginate($perPage);

            if ($path) {
                $fichas->withPath($path);
            }
        } else {
            $fichas = $fichasQuery->get();
        }

        return $fichas;
    }

    // public static function storeSessionFilters(Request $filters)
    // {
    //     // $filters->session($filters);
    //     session($filters->query());
    // }

    /**
     * Añade where al queryBuilder con los filtros
     *
     * @param  \Illuminate\Database\Eloquent\Builder  query
     * @param  array  filters
     */
    private static function addModelFilters(Builder &$query, $filters)
    {
        $ficha = new Ficha;

        $modelFilters = $ficha->getSearchableModelFilters();

        foreach ($modelFilters as $filter) {
            if (isset($filters[$filter])) {
                $query->where('fichas.' . $filter . '_id', $filters[$filter]);
            }
        }
    }

    /**
     * Añade los joins y condicion where necesarias para la búsqueda
     *
     * @param  \Illuminate\Database\Eloquent\Builder  query
     * @param  array  filters
     */
    private static function addJoinsWhere(Builder &$query, $filters)
    {
        $ficha = new Ficha;

        $models = $ficha->getSearchableModels();

        if (isset($filters['query'])) {
            $querytextexplode = explode(' ', $filters['query']);
            $querytext='%';
            foreach ($querytextexplode as $query_word) {
                $querytext.= ''.$query_word.'%';
            }
            // Añadir un leftJoin por cada modelo relacionado
            foreach ($models as $model) {
                $query->leftJoin($model. 's', 'fichas.' . $model . '_id', '=', $model . 's.id');
            }

            // Añadir al where los campos y modelos buscables
            $whereRaw = '(';

            $fields = $ficha->getSearchableFields();
            $first = true;

            // Campos buscables
            foreach ($fields as $field) {
                if ($filters['search_key'] == 'todas') {
                    if ($first) {
                        $whereRaw .= 'fichas.' . $field . ' like "' . $querytext. '"';
                        $first = false;
                    } else {
                        $whereRaw .= ' or fichas.' . $field . ' like "' . $querytext . '"' ;
                    }
                } else {
                    foreach ($querytextexplode as $query_word) {
                        if ($first) {
                            $whereRaw .= 'fichas.' . $field . ' like "%' . $query_word. '%"';
                            $first = false;
                        } else {
                            $whereRaw .= ' or fichas.' . $field . ' like "%' . $query_word . '%"' ;
                        }
                    }
                }
            }
            // Modelos buscables
            foreach ($models as $model) {
                $whereRaw .= ' or ' . $model. 's.nombre like "' . $querytext . '"';
            }

            $query->whereRaw($whereRaw . ')');
        }
    }
}
