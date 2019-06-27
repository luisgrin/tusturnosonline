<?php

use Dingo\Api\Routing\Router;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Illuminate\Support\Facade;
use Illuminate\Http\Request;
use App\Opcion;
use App\Seccion;
use App\Cliente;
use App\Atributo;
use App\ClienteAtributo;

function validate_atribute($id,$valor){
    $atributo = App\Atributo::where('id',$id)
        ->first(); 
    switch($atributo->tipo){
        case 'entero':
            if(!preg_match('/^[0-9]{1,20}$/', $valor)) {
                return ['error' => 'El valor debe ser un entero.'];
            }
            break;

        case 'decimal':
            if(!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $valor)) {
                return ['error' => 'El valor debe ser un decimal.'];
            }
            break;

        case 'fecha':
            if(DateTime::createFromFormat('Y-m-d H:i:s', $valor) !== FALSE) {
                return ['error' => 'El valor debe ser una fecha.'];
            }                
            break;

        case 'direccion_google':
            if(!preg_match('/(.*) (\d)/', $valor)) {
                return ['error' => 'El valor debe ser una dirección.'];
            }
            break;

        case 'caracter':
            if(is_numeric($valor) OR strlen($valor) != 1) {
                return ['error' => 'El valor debe ser un caracter.'];
            }
            break;

    }    
    return [];
}
/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    /* auth public methods */

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    /* auth area */

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {

        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        /* auth refresh */

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        /* cruds */

        $api->get('clientes', function() {
            $data = App\Cliente::where('user_id',Auth::user()->id)->get();
            return response()->json($data);
        });

        $api->get('clientes/{id}', function($id) {
            $data = App\Cliente::where('user_id',Auth::user()->id)
                ->where('id',$id)
                ->first();    
            return response()->json($data);
        });

        $api->post('cliente', function(Request $request) {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $item = new App\Cliente($data);
            if(!$item->save()) {
                throw new HttpException(500);
            }
            return response()->json($item);
        });

        $api->post('cliente/{id}', function(Request $request,$id) {
            $data = App\Cliente::find($id);
            if(empty($data) OR !$data->update($request->all())){
                throw new HttpException(500);
            }
            return response()->json($data);
        });  

        $api->delete('cliente/{id}', function($id) {
            $deleted = App\Cliente::where('user_id', Auth::user()->id)
                ->where('id',$id)
                ->delete();
            return response()->json($deleted);
        });

        /**/

        $api->get('atributos', function() {
            $data = App\Atributo::where('user_id',Auth::user()->id)->get();
            return response()->json($data);
        });

        $api->get('atributos/{id}', function($id) {
            $data = App\Atributo::where('user_id',Auth::user()->id)
                ->where('id',$id)
                ->first();    
            return response()->json($data);
        });

        $api->post('atributo', function(Request $request) {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $item = new App\Atributo($data);
            if(!$item->save()) {
                throw new HttpException(500);
            }
            return response()->json($item);
        });

        $api->post('atributo/{id}', function(Request $request,$id) {
            $data = App\Atributo::find($id);
            if(empty($data) OR !$data->update($request->all())){
                throw new HttpException(500);
            }
            return response()->json($data);
        });  

        $api->delete('atributo/{id}', function($id) {
            $deleted = App\Atributo::where('user_id', Auth::user()->id)
                ->where('id',$id)
                ->delete();
            return response()->json($deleted);
        });

        /* carga de datos */

        $api->get('clientes/buscar/{keyword}', function($keyword) {
            $data = App\Cliente::where('user_id', Auth::user()->id)
                ->where('nom', 'like', '%' . $keyword . '%')
                ->take(10)
                ->get();
            return response()->json($data);
        });

        $api->get('atributos/buscar/{keyword}', function($keyword) {
            $data = App\Atributo::where('user_id', Auth::user()->id)
                ->where('nom', 'like', '%' . $keyword . '%')
                ->take(10)
                ->get();
            return response()->json($data);
        });

        $api->get('clientes/atributos/{id}', function($id) {
            $data = App\Cliente::where('user_id',Auth::user()->id)
                ->where('id',$id)
                ->first();    
            $data->atributos = App\ClienteAtributo::where('cliente_id', $id)
                ->get();
            return response()->json($data);
        });

        $api->post('clienteatributo', function(Request $request) {
            $data = $request->all();
            extract($data);

            $valor = trim($valor);
            $validacion = \validate_atribute($crm_atributo_id,$valor);

            if(count($validacion)){
                return response()->json($validacion);
            }

            $item = new App\ClienteAtributo($data);
            if(!$item->save()) {
                throw new HttpException(500);
            }
            return response()->json($item);
        });


        $api->post('clienteatributo/{id}', function(Request $request, $id) {
            $data = $request->all();
            extract($data);

            $valor = trim($valor);
            $validacion = \validate_atribute($crm_atributo_id,$valor);

            if(count($validacion)){
                return response()->json($validacion);
            }

            $item = App\ClienteAtributo::find($id);
            if(!$item->update($data)) {
                throw new HttpException(500);
            }
            return response()->json($item);
        });

        $api->delete('clienteatributo/{id}', function($id) {
            $deleted = App\ClienteAtributo::where('id',$id)
                ->delete();
            return response()->json($deleted);
        });

        /* mi cuenta */

        $api->post('updateme', function(Request $request) {
            $data = App\User::find(Auth::user()->id)
                ->first();

            if(empty($data) OR !$data->update($request->all())){
                throw new HttpException(500);
            }

            return response()->json($data);
        });

        $api->post('fotoperfil', function(Request $request) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $imageName = time().'.'.request()->image->getClientOriginalExtension();

            $request->image->move(public_path('upload'), $imageName);

            $data = $request->all();
            $item = App\User::find(Auth::user()->id);
            $item->foto = $imageName;

            if(!$item->save()) {
                throw new HttpException(500);
            }

            return response()->json($item);
        });
    });

    /* public methods */

    $api->post('navitems', function() {
        $footer = App\Opcion::where('nom','APP_FOOTER')->first();
        $navitems = App\Seccion::where('is_navitem',1)->select(['slug','title'])->get();
        return response()->json([
            'footer' => $footer->valor,
            'navitems' => $navitems,
        ]);
    });

    $api->post('secciones/{slug}', function($slug) {
        $section = App\Seccion::where('slug','/'.$slug)->first();
        if(!$section) {
            throw new NotFoundHttpException();
        }
        return response()->json($section);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
