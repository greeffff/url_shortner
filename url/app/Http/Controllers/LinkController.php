<?php
namespace App\Http\Controllers;
use View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Request; 
use URL;
use App\Link as Link;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LinkController extends BaseController{
	public function make(){
		$validator = Validator::make(Input::all(), array(
		'url' => 'required|url|max:255'));
		if ($validator->fails()){
			return Redirect::action('HomeController@index')->withInput()->withErrors($validator);
		} else
		{
			$url = Input::get('url');
			$code = null;
			$exists = Link::where('url', $url);
			if($exists->count() == 1)
			{
					$code = $exists->first()->code;
			}
			else
			{
					$created = Link::create(array(
					'url' => $url
					));
					if($created){
						$timeNow = Carbon::now();
						$client  = Request::ip();
						$code = base_convert($created->id, 10, 36);
						Link::where('id', '=', $created->id)->update(array(
						'code'=>$code));
						}
						$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
						fwrite($fd, "[".$timeNow."]"."  ". "[IP: ".$client."]". "  ". "URL:". $url. "  ". "SHORTURL: ". $url. "/". $code. PHP_EOL);
						fclose($fd);
			}
			if($code){
				return Redirect::action('HomeController@index')->with('global', 'Ваша ссылка:<a href="' . URL::action('LinkController@get', $code) . '">' . URL::action('LinkController@get', $code) . '</a>');
			}
		}
		return Redirect::action('HomeController@index')->with('global', 'Что-то пошло не так, повторите.');

	}
	public function getLink($id)
	{
		$link = Link::find($id);
		if($link==true)
		{ 
			$timeNow = Carbon::now();
			$client  = Request::ip();
			$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
			fwrite($fd, "[".$timeNow."]"."  ". "[IP: ".$client."]". "  ". "USED GETLINK API FOR: ". $link. PHP_EOL);
			fclose($fd);
			return response()->json($link, 200);
		}
		else
		{
			return response()->json(['answer' => 'Ссылка не существует'], 404) ;
		}
	}
	public function createLink()
	{
			$timeNow = Carbon::now();
			$client  = Request::ip();
			$url = Input::get('url');
			$code = null;
			$exists = Link::where('url', $url);
			if($exists->count() == 1)
			{
					$code = $exists->first()->code;
					return response()->json(['answer' => 'url уже есть'], 404);
			}
			else
			{
					if($url==null)
					{
						return response()->json(['answer' => 'url не введен'], 404);
					}
					$created = Link::create(array(
					'url' => $url
					));
					if($created){
						$code = base_convert($created->id, 10, 36);
						Link::where('id', '=', $created->id)->update(array(
						'code'=>$code));
						}
						return response()->json(['answer' => 'Link shorted'], 200);
						$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
						fwrite($fd, "[".$timeNow."]"."  ". "[IP: ".$client."]". "  ". "URL:". $url. "  ". "USED CREATELINK API  SHORTURL: ". $url. "/". $code. PHP_EOL);
						fclose($fd);
			}
	}
	public function deleteLink($id)
	{
		$timeNow = Carbon::now();
		$client  = Request::ip();
		$link = Link::where('id', '=', $id);
		if ($link->count()===1)
		{
			$link->delete();
			return response()->json(['answer' => 'Ссылка удалена'], 200);
		}
		else
		{
			return response()->json(['answer' => 'Ссылка не найдена'], 404);
		}
	}
	public function showAllLinks()
	{
		$timeNow = Carbon::now();
		$client  = Request::ip();
		$link=Link::all();
		if($link->count()===0){
			$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
			fwrite($fd, "[".$timeNow."]"."  ". "[IP: ".$client."]".  "  ". "USED SHOWALLLINKS API". PHP_EOL);
			fclose($fd);
			return response()->json(['answer' => 'Ссылки отсутсвуют'], 404);
		}
		else
		{
			return response()->json($link, 200);
		}
	}
	public function changeLink($id)
	{
		$timeNow = Carbon::now();
		$client  = Request::ip();
		$link = Link::find($id);
		$code = Input::get('code');
		if($link)
		{
			$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
			fwrite($fd, "[".$timeNow."]"."  ". "[IP: ".$client."]". "  ". "URL:". $link. "  ". "USED CHANGELINK API. NEW LINK IS ". $link. "/". $code. PHP_EOL);
			fclose($fd);
			$link->update(array('code'=>$code));
			return response()->json($link, 200);
		}
		else
		{
			return response()->json(['answer' => 'Ссылка не существует'], 404);
		}
	} #  sudo curl -X PUT -d code=228 192.168.0.63/api/changeLink/1
	public function get($code){
		$link = Link::where('code', '=', $code);
		if($link->count()===1){
			$hits = $link->first()->hits+1;
			$link->update(array('hits'=>$hits));
			return Redirect::to($link->first()->url);
		}
		return Redirect::action('HomeController@index');
	}
}