<Placemark>
    <name>{{$ficha->denominacion}}</name>
    <description>
        <![CDATA[
        @include('fichas.partials.infowindow')
        ]]>
    </description>
    <Point>
        <coordinates>{{$coords['lon']}},{{$coords['lat']}}</coordinates>
    </Point>
</Placemark>

