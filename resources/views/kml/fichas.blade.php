@php echo '<?xml version="1.0" encoding="UTF-8"?>' @endphp
<kml xmlns="http://www.opengis.net/kml/2.2">
    <Document>
        @foreach($kmlInfo as $data)
            <Placemark>
                <name>{{$data['ficha']->denominacion}}</name>
                <description>
                    <![CDATA[
                    @include('fichas.partials.infowindow',
                    [
                        'ficha' => $data['ficha'],
                        'descripcion' => $data['descripcion'],
                        'tipologias' => $data['tipologias'],
                    ])
                    ]]>
                </description>
                <Point>
                    <coordinates>{{$data['coords']['lon']}},{{$data['coords']['lat']}}</coordinates>
                </Point>
            </Placemark>
        @endforeach
    </Document>
</kml>
