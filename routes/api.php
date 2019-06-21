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

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        $api->get('clientes', function() {
            $data = App\Cliente::where('user_id',Auth::user()->id)->get();
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

        $api->post('cliente/{id}', function($id) {
            $data = App\Cliente::find($id);
            if(empty($data) OR !$data->save($request->all())){
                throw new HttpException(500);
            }
            return response()->json($data);
        });            

        $api->get('clientes/{id}', function($id) {
            $data = App\Cliente::where('user_id',Auth::user()->id)
                ->where('id',$id)
                ->first();    
            return response()->json($data);
        });

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
    });

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
