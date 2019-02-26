<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
/** 
* @SWG\Swagger( 
* basePath="/api", 
* schemes={"http"}, 
* @SWG\Info( 
* version="1.0.0", 
* title="PROJECT TITLE", 
* @SWG\Contact( 
* email="your@email.com" 
* ), 
* ) 
* ) 
*/ 

/** 
* @SWG\SecurityScheme( 
* securityDefinition="api_key", 
* type="apiKey", 
* in="query", 
* name="api_key" 
* ) 
*/
class SwaggerController extends Controller
{
    public function doc()
    {
        $swagger = \Swagger\scan(realpath(__DIR__.'/../../'));
        return response()->json($swagger);
    }
}