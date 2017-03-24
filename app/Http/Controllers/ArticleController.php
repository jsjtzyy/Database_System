<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
//use Request;
use Carbon\Carbon;
use App\Article;   // important;
use laravelcollective\html;
//use Collective\Html;
class ArticleController extends Controller
{
    //
    public function index()
    {
        //$articles = Article::all();
        $articles = DB::select('SELECT * FROM articles ORDER BY id');
        //$articles = Article::latest()->get();
        return view('articles.index',compact('articles'));
    }


    public function show($id)
	{
		//$article = Article::find($id);
        $articles = DB::select('SELECT * FROM articles WHERE id = ?', [$id]);
        if(is_null($articles)){
           abort(404);
        }
    	return view('articles.show',compact('articles'));
	}

	public function create()
    {
        return view('articles.create');
    }

    public function store(Requests\StoreArticleRequest $request)
    {
    	$input = $request -> all();
    	$input['intro'] = mb_substr($request->get('content'),0,64);
    	//$input = Request::all();
        Article::create($input);
        return redirect('/');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        //$tags = Tag::lists('name', 'id');
        return view('articles.edit',compact('article'));
    }

    public function update(Requests\StoreArticleRequest $request)
    {
        //根据id查询到需要更新的article
        $article = Article::find($request->get('id'));
        //使用Eloquent的update()方法来更新，
        //request的except()是排除某个提交过来的数据，我们这里排除id
        $article->update($request->except('id'));
        // 跟attach()类似，我们这里使用sync()来同步我们的标签
        //$article->tags()->sync($request->get('tag_list'));
        return redirect('/');
    }

    public function delete($id){
        $article = Article::findOrFail($id);
        $article -> delete();
        return redirect('/');
    }
}
