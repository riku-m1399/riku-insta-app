<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/images/';
    private $post;
    private $catagory;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        #1 Validation
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2 recieved all data from form
        $this->post->user_id = Auth::user()->id; // store the id of the user who createdthe post
        $this->post->description = $request->description;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->save(); // INSERT INTO posts(user_id, image, description) VALUE('Auth::user()->id, $image, $request->description)

        #3 Save categories
        foreach ($request->category as $category_id){
            // 1 = food, 2 = travel, 3 = lifestyle
            $category_post[] = ['category_id' => $category_id];
            // $category_post[1, 2, 3]
        }
        // This line will insert the post_id and category_id into the
        // category_post PIVOT table in the database
        $this->post ->categoryPost()->createMany($category_post);
        // createMany() ---> requires that we have a ['key' => 'value'] pair of data

        // Given/Data:
        //  $this->post->id(1)
        // $request->category[1, 2, 3]

        // After the $this->post ->categoryPost()
        // $category_post = [
        //      ['post_id' => 1, 'category_id => 1],
        //      ['post_id' => 1, 'category_id => 2],
        //      ['post_id' => 1, 'category_id => 3]
        // ];

        #4 Go back to homepage
        return redirect()->route('index');
    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);
        
        // If the AUTH user is not the owner of the post, redirect to homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

        // retrieved all the categories
        $all_categories = $this->category->all();

        // Get all the categories of this post and save it in an array
        $selected_categories = []; // This is an empty array for now

        foreach($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
            ->with('post',$post) // coming from line 73, it contains entire row of data from Db
            ->with('all_categories', $all_categories) // from line 81, it contains all categories from Db
            ->with('selected_categories', $selected_categories); // from line 87, after the loop the array will have all the categories under this post
    }

    public function update(Request $request, $id){
        #1. Validate the data from the form
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        #2. Update the post

        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        // if there is a new image...
        if($request->image){
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        #3. Delete all the records from category_post related to this post
        $post->categoryPost()->delete();
        // Use the relationship Post::categoryPost() to select the recors related to a post
        // Equivalent: DELETE FROM category_post WHERE post_id = $id;

        #4. Save the new categories to category
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }

        $post->categoryPost()->createMany($category_post);

        #5. Redirect to Show Post Page (toconfirm the update)
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        $this->post->findOrFail($id)->forceDelete();

        return redirect()->route('index');
    }
}
