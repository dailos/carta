<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/distance', function () {

// 	// line segment
// 	$a['lat'] = 28.134116;
// 	$a['lon'] = -15.43443;
// 	$b['lat'] = 28.107359;
// 	$b['lon'] = -15.460959;
// 	$c['lat'] = 28.079535;
// 	$c['lon'] = -15.464307;

// 	$polyline = array($a, $b, $c);
	
// 	// point
// 	$point['lat'] = 28.107480;
// 	$point['lon'] = -15.443879;

// 	$d = \App\Maps\GeoDistance::getGeoDistancePointToPolyline($polyline, $point);
// 	dd(round($d));
// });

// RUTAS PÚBLICAS

// Página inicial
Route::get('/', 'FichaController@index')->name('home');

Route::name('fichas.')->group(function () {
	// Ficha
	Route::get('fichas/{cod_ficha}', 'FichaController@show')->name('show');

	Route::get('fichas/descargar/{cod_ficha}', 'FichaController@download')->name('download');

	Route::get('resultados/descargar', 'FichaController@downloadResults')->name('download.results');

    Route::get('resultados/descargarkml', 'FichaController@downloadKml')->name('download.kml');

	// Acceso a ficha concreta
	Route::post('acceso-directo', 'FichaController@searchByCode')->name('search.code');

	// Búsqueda
	Route::get('busqueda', 'FichaController@search')->name('search');

	// Búsqueda geográfica
	Route::post('busqueda-geografica-file', 'FichaController@readKmlFile')->name('search.geo.file');
	Route::get('busqueda-geografica', 'FichaController@geoSearch')->name('search.geo');

	// Búsqueda proximidad geográfica
	Route::get('busqueda-prox-geografica', 'FichaController@geoProxSearch')->name('search.geoprox');
});

// Rutas del usuario colaborador
Route::prefix('user')->name('collaborator.')->middleware(['auth', 'role:collaborator'])->group(function () {
	// Route::view('panel', 'collaborator.index')->name('panel');

	Route::namespace('Collaborator')->group(function () {
		// Ruta pagina incial
		Route::get('/', ['as' => 'index', 'uses' => 'FichaController@index']);

		// Rutas de gestión de fichas
		Route::resource('fichas', 'FichaController')->except('destroy');
		Route::post('datatable', 'FichaController@fichas')->name('fichas.datatable'); // Ajax para el datatable

		// Rutas de gestión de peticiones
		Route::resource('peticiones', 'FichaRequestController')->parameters([
		    'peticiones' => 'moderableRecord'
		])->only(['index', 'show', 'destroy']);

		// Rutas de historial de peticiones
		Route::resource('historial', 'FichaHistoryController')->parameters([
		    'historial' => 'moderableRecord'
		])->only(['index', 'show']);
	});
});

// Rutas para administradores y colaboradores
Route::group(['middleware' => ['role:admin|collaborator']], function () {
	// Peticiones ajax de municipios y localidades
    Route::get('municipios/{isla}', 'MunicipioController@getMunicipios')->name('get_municipios');
	Route::get('localidades/{municipio}', 'LocalidadController@getLocalidades')->name('get_localidades');

	// Gestión del perfil del usuario
	Route::get('perfil', 'ProfileController@show')->name('profile.show');
	Route::get('perfil/edit', 'ProfileController@edit')->name('profile.edit');
	Route::put('perfil', 'ProfileController@update')->name('profile.update');
	Route::get('changePassword','ProfileController@showChangePasswordForm')->name('profile.show.changepassword');
	Route::post('changePassword','ProfileController@changePassword')->name('profile.changepassword');
});

// Rutas del administrador
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
	
	Route::resource('municipios', 'MunicipioController')->only(['index', 'store', 'update', 'destroy']);
	Route::resource('localidades', 'LocalidadController')->parameters([
	    'localidades' => 'localidad'
	])->only(['index', 'store', 'update', 'destroy']);

    // Fichas
	Route::namespace('Admin')->group(function () {
		// Ruta pagina incial
	    Route::get('/', ['as' => 'index', 'uses' => 'FichaController@index']);

	    // Rutas configuración
	    Route::resource('configuracion', 'ConfigController')->only(['index', 'store', 'update', 'destroy']);

	    // Rutas de gestión de usarios
	    Route::resource('users', 'UserController');
	    Route::get('users/delete/{user}', ['as' => 'users.delete', 'uses' => 'UserController@destroy']);

	    // Rutas de gestión de fichas
		Route::resource('fichas', 'FichaController');
		Route::post('datatable', 'FichaController@fichas')->name('fichas.datatable'); // Ajax para el datatable

		// Rutas de gestión de moderaciones
		Route::post('moderacion/aceptar', 'FichaModerationController@accept')->name('moderacion.accept');
		Route::post('moderacion/rechazar', 'FichaModerationController@reject')->name('moderacion.reject');
		Route::resource('moderacion', 'FichaModerationController')->parameters([
		    'moderacion' => 'moderableRecord'
		])->only(['index', 'show', 'edit', 'update']);

		// Rutas de historial de moderaciones
		Route::resource('historial', 'FichaHistoryController')->parameters([
		    'historial' => 'moderableRecord'
		])->only(['index', 'show', 'destroy']);
	});

	// Gestión de usuarios
	Route::namespace('Users')->group(function () {
	    // Controllers Within The "App\Http\Controllers\Users" Namespace

		Route::resource('administrators', 'AdministratorController')->parameters([
		    'administrators' => 'user'
		]);

		Route::resource('collaborators', 'CollaboratorController')->parameters([
		    'collaborators' => 'user'
		]);

	    Route::get('administrators/delete/{user}', ['as' => 'administrators.delete', 'uses' => 'AdministratorController@destroy']);

	    Route::get('collaborators/delete/{user}', ['as' => 'collaborators.delete', 'uses' => 'CollaboratorController@destroy']);
	});
	
});

Route::get('fotos/{media_id}', function ($foto_id) {
    $foto = \App\Foto::find($foto_id);
    if(!\Illuminate\Support\Facades\Storage::exists($foto->src)) abort(404);
    $file = \Illuminate\Support\Facades\Storage::get($foto->src);
    $type = \Illuminate\Support\Facades\Storage::mimeType($foto->src);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

