@isset($models)
<p>Página {{ $models->currentPage() }} de {{ $models->lastPage() }}, mostrando {{ $models->perPage() }} registros por página de un total de {{ $models->total() }}, comenzando en el {{ $models->firstItem() }} y acabando en el {{ $models->lastItem() }}. @if($search) Filtrando por: "{{ $search }}" @endif</p>
@endisset