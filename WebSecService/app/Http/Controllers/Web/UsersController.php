<?php

// namespace App\Http\Controllers\Web;

// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Validation\Rules\Password;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
// use DB;
// use Artisan;

// use App\Http\Controllers\Controller;
// use App\Models\User;

// class UsersController extends Controller {

// 	use ValidatesRequests;

//     public function list(Request $request) {
//         if(!auth()->user()->hasPermissionTo('show_users'))abort(401);
//         $query = User::select('*');
//         $query->when($request->keywords, 
//         fn($q)=> $q->where("name", "like", "%$request->keywords%"));
//         $users = $query->get();
//         return view('users.list', compact('users'));
//     }

// 	public function register(Request $request) {
//         return view('users.register');
//     }

//     public function doRegister(Request $request) {

//     	try {
//     		$this->validate($request, [
//                 'name' => ['required', 'string', 'max:255'],
//                 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//                 'password' => ['required', 'string', 'min:8', 'confirmed'],
// 	    	]);
//     	}
//     	catch(\Exception $e) {

//     		return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
//     	}

    	
//     	$user =  new User();
// 	    $user->name = $request->name;
// 	    $user->email = $request->email;
// 	    $user->password = bcrypt($request->password); //Secure
// 	    $user->save();

//         return redirect('/');
//     }

//     public function login(Request $request) {
//         return view('users.login');
//     }

//     public function doLogin(Request $request) {
    	
//     	if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
//             return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

//         $user = User::where('email', $request->email)->first();
//         Auth::setUser($user);

//         return redirect('/');
//     }

//     public function doLogout(Request $request) {
    	
//     	Auth::logout();

//         return redirect('/');
//     }

//     public function profile(Request $request, User $user = null)
// {
//     $user = $user ?? auth()->user();

//     // If $user is still null, redirect to login
//     if (!$user) {
//         return redirect()->route('login')->with('error', 'Please log in to view your profile.');
//     }

//     if (auth()->id() != $user->id) {
//         if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
//     }

//     $permissions = [];
//     foreach ($user->permissions as $permission) {
//         $permissions[] = $permission;
//     }
//     foreach ($user->roles as $role) {
//         foreach ($role->permissions as $permission) {
//             $permissions[] = $permission;
//         }
//     }

//     $purchases = $user->purchases()->with('product')->get();

//     return view('users.profile', compact('user', 'permissions', 'purchases'));
// }


// public function edit(Request $request, User $user = null)
// {
//     $user = $user ?? auth()->user();

//     if (!$user) {
//         return redirect()->route('login')->with('error', 'Please log in to edit your profile.');
//     }

//     if (auth()->id() != $user->id) {
//         if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
//     }

//     $roles = [];
//     foreach (Role::all() as $role) {
//         $role->taken = ($user->hasRole($role->name));
//         $roles[] = $role;
//     }

//     $permissions = [];
//     $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
//     foreach (Permission::all() as $permission) {
//         $permission->taken = in_array($permission->id, $directPermissionsIds);
//         $permissions[] = $permission;
//     }

//     return view('users.edit', compact('user', 'roles', 'permissions'));
// }

// public function save(Request $request, User $user)
// {
//     if (!$user) {
//         return redirect()->route('login')->with('error', 'User not found.');
//     }

//     if (auth()->id() != $user->id) {
//         if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
//     }

//     $user->name = $request->name;
//     $user->save();

//     if (auth()->user()->hasPermissionTo('admin_users')) {
//         $user->syncRoles($request->roles);
//         $user->syncPermissions($request->permissions);
//         Artisan::call('cache:clear');
//     }

//     return redirect(route('profile', ['user' => $user->id]));
// }

// public function delete(Request $request, User $user)
// {
//     if (!$user) {
//         return redirect()->route('users')->with('error', 'User not found.');
//     }

//     if (!auth()->user()->hasPermissionTo('delete_users')) abort(401);

//     $user->delete();

//     return redirect()->route('users');
// }

// public function savePassword(Request $request, User $user)
// {
//     if (!$user) {
//         return redirect()->route('login')->with('error', 'User not found.');
//     }

//     if (auth()->id() == $user->id) {
//         $this->validate($request, [
//             'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
//         ]);

//         if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
//             Auth::logout();
//             return redirect('/');
//         }
//     } else if (!auth()->user()->hasPermissionTo('edit_users')) {
//         abort(401);
//     }

//     $user->password = bcrypt($request->password);
//     $user->save();

//     return redirect(route('profile', ['user' => $user->id]));
// }

//     public function editPassword(Request $request, User $user = null)
// {
//     $user = $user ?? auth()->user();

//     if (!$user) {
//         return redirect()->route('login')->with('error', 'Please log in to change your password.');
//     }

//     if (auth()->id() != $user->id) {
//         if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
//     }

//     return view('users.edit_password', compact('user'));
// }

//     protected function create(array $data)
//     {
//         return User::create([
//             'name' => $data['name'],
//             'email' => $data['email'],
//             'password' => Hash::make($data['password']),
//             'role' => 'Customer', 
//             'credit' => 0.00,
//         ]);
//     }

    
// } 



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('product')->get();
        return view('profile', compact('user', 'purchases'));
    }

    public function customers()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('name', 'Customer'))->get();
        return view('customers', compact('customers'));
    }

    public function addCredit(Request $request, User $user)
    {
        $request->validate(['credit' => 'required|numeric|min:0']);
        $user->credit += $request->credit;
        $user->save();
        return redirect()->back()->with('success', 'Credit added');
    }

    public function createEmployee(Request $request)
    {
        // Logic to create employee
    }
}