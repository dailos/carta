<div class="row">
      <template v-if="municipio_buscador == 10 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 10]) }}"><img src="{{ asset('images/agaete.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Agaete</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 16 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 16]) }}"><img src="{{ asset('images/galdar.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Gáldar</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 24 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 24]) }}"><img src="{{ asset('images/guia.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Santa María de Guía</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 19 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 19]) }}"><img src="{{ asset('images/moya.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Moya</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 15 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 15]) }}"><img src="{{ asset('images/firgas.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Firgas</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 14 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 14]) }}"><img src="{{ asset('images/arucas.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Arucas</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 20 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 20]) }}"><img src="{{ asset('images/laspalmas.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Las Palmas de Gran Canaria</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 28 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 28]) }}"><img src="{{ asset('images/valleseco.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Valleseco</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 27 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 27]) }}"><img src="{{ asset('images/teror.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Teror</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 22 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 22]) }}"><img src="{{ asset('images/santabrigida.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Santa Brígida</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 25 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 25]) }}"><img src="{{ asset('images/tejeda.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Tejeda</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 29 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 29]) }}"><img src="{{ asset('images/valsequillo.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Valsequillo</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 30 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 30]) }}"><img src="{{ asset('images/sanmateo.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Vega de San Mateo</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 13 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 13]) }}"><img src="{{ asset('images/artenara.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Artenara</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 18 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 18]) }}"><img src="{{ asset('images/mogan.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Mogán</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 21 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 21]) }}"><img src="{{ asset('images/sbartolome.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>San Bartolomé de Tirajana</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 26 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 26]) }}"><img src="{{ asset('images/telde.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Telde</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 17 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 17]) }}"><img src="{{ asset('images/ingenio.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Ingenio</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 11 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 11]) }}"><img src="{{ asset('images/aguimes.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Agüimes</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 23 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 23]) }}"><img src="{{ asset('images/santalucia.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Santa Lucía de Tirajana</strong></div>
      </div>
      </template>

      <template v-if="municipio_buscador == 12 || municipio_buscador == '-'">
      <div class="col-lg-4">
            <a href="{{ route('fichas.search', ['municipio' => 12]) }}"><img src="{{ asset('images/snicolas.png') }}" class="img-fluid" style="width:350px; height:208px"></a>
            <div class="text-center marg"><strong>Aldea de San Nicolás, La</strong></div>
      </div>
      </template>
</div>



      












