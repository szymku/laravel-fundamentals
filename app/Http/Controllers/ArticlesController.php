<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use Carbon\Carbon;
use Auth;
use App\Tag;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    public function index()
    {
        
        $articles = Article::latest('published_at')->published()->get();
        
        return view('articles.index', compact('articles'));
    }
    
    public function show(Article $article)
    {
        
        return view('articles.show', compact('article'));
    }
    
    public function create()
    {
        $tags = Tag::lists('name', 'id');
        
        return view('articles.create', compact('tags'));
    }
    
    public function store(ArticleRequest $request)
    {
        
        $this->createArticle($request);
        
        flash()->message('Your article has been successfully created!');
        
        return redirect('articles');
    }
    
    public function edit(Article $article)
    {
        $tags = Tag::lists('name', 'id');
        
        return view('articles.edit', compact('article', 'tags'));
    }
    
    public function update(Article $article, ArticleRequest $request)
    {
        
        $article->update($request->all());
        
        $this->syncTags($article, $request->input('tag_list'));
        
        return redirect('articles');
    }
    
    private function syncTags(Article $article, array $tags)
    {
        $article->tags()->sync($tags);
    }
    
    private function createArticle(ArticleRequest $request)
    {
        $article = Auth::user()->articles()->create($request->all());
        
        $this->syncTags($article, $request->input('tag_list'));

        return $article;
    }
}
