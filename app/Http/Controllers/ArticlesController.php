<?php namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Tag;

class ArticlesController extends Controller {

	/**
	 * Create a new article controller instance
	 */
	public function __construct() {

		$this->middleware('auth', ['only' => 'create']);

	}

	public function index() {

		$articles = Article::latest('published_at')->published()->get();

		return view('articles.index', compact('articles'));

	}

	public function show(Article $article) {

		return view('articles.show', compact('article'));

	}

	public function create() {

		$tags = Tag::lists('name', 'id');

	  	return view('articles.create', compact('tags'));

	}

	public function store(ArticleRequest $request) 

	{
		$this->createArticle($request);

		flash()->overlay('Your article has been successfully created!', 'Good Job!');

		return redirect('articles');
	}

	public function edit(Article $article) {

		$tags = Tag::lists('name', 'id');

		return view('articles.edit', compact('article', 'tags'));
	}

	public function update(Article $article, ArticleRequest $request) {

		$article->update($request->all());

		$this->syncTags($article, $request->input('tag_list'));

		return redirect('articles');
	}

	/**
	 * Sync up the list of tags in the database.
	 * 
	 * @param  ArticleRequest $request
	 * @param  Article 		  $article
	 */
	private function syncTags(Article $article, array $tags) {

		$article->tags()->sync($tags);

	}

	/**
	 * Save a new article
	 * @param  ArticleRequest $request
	 * @return mixed
	 */
	private function createArticle(ArticleRequest $request) {
		$article = Auth::user()->articles()->create($request->all());

		$this->syncTags($article, $request->input('tag_list'));

		return $article;
	}

}
