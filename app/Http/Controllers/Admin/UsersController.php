<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(5);
        return view('admin.users.index')->with('all_users', $all_users);
    }

    // This will souft delete a user. In User.php, we used SoftDeletes; therefore, all users that will be deleted/destroyed are only soft deleted.
    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id){
        // onlyTrashed() - select the spft deleted records only
        // restore() - reverses the soft delete / deleted_at column will become NULL
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
