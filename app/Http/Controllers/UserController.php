<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        $userRoles = array();
        foreach($users as $user){
            $ur = $user->userRoles($user->id);
            $roles = array();
            //tylko nazwy, id nie potrzebne
            foreach ($ur as $r){
                array_push($roles, $r['name']);
            }
            $userRoles[$user->id] = $roles;
        }
        return view('users.index', ['users' => $users, 'userRoles' => $userRoles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $types = UserType::all();
        $departments = Department::all();
        return view('users.create', ['types' => $types, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //dd($request);
        $user = new User($request->validated());
        $user->setAttribute('password', Str::random(32));
        //dd($user->getAttributes());
        $user->save();
        return redirect(route('users.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $types = UserType::all();
        $departments = Department::all();
        return view('users.show', ['user'=>$user, 'types' => $types, 'departments' => $departments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        //
        $types = UserType::all();
        $departments = Department::all();
        return view('users.edit', ['user'=>$user, 'types' => $types, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->validated());
        //dd($user);
        $user->save();
        return redirect(route('users.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'status' => 'success'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
            ],500);
        }
    }
}
