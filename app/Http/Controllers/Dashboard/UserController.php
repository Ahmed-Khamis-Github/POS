<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {

            return $q->when($request->search, function ($query) use ($request) {

                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);


        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'image' => 'image'

        ]);

        $request_date =  $request->except('password', 'image');
        $request_date['password'] = bcrypt($request->password);
        if ($request->image) {
            $img = Image::make($request->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));

            $request_date['image'] = $request->image->hashName();
        }

        $user = User::create($request_date);

        $user->attachRole('admin');

        $user->attachPermissions($request->permissions);


        return redirect()->route('dashboard.users.index')->with('success', 'User Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => 'image'
        ]);

        $request_date =  $request->except('password', 'image');

        if ($request->image) {
            if ($user->image != 'default.jpg') {
                Storage::disk('public_path')->delete('users_images/' . $user->image);
            }
            $img = Image::make($request->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));

            $request_date['image'] = $request->image->hashName();
        }
        $user->update($request_date);
        $user->syncPermissions($request->permissions);
        return redirect()->route('dashboard.users.index')->with('success', 'User updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->image   != 'default.jpg') {
            Storage::disk('public_path')->delete('users_images/' . $user->image);
        }
        $user->delete();
        return redirect()->route('dashboard.users.index')->with('success', 'User Deleted Successfully');
    }
}
