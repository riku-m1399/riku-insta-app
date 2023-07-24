<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $category;
    
    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->latest('updated_at')->get();
        $post = $this->post;
        if(count($post->categoryPost) == 0){
            $uncategorized_post[] = $post->id;
        }
        
        return view('admin.categories.index')->with('all_categories', $all_categories)->with('uncategorized_post', $uncategorized_post);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:1|unique:categories'
        ]);

        $this->category->name = ucwords($request->name);
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|min:1|unique:categories'
        ]);

        $category = $this->category->findOrFail($id);
        $category->name = ucwords($request->name);
        $category->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);
        return redirect()->back();
    }
}
