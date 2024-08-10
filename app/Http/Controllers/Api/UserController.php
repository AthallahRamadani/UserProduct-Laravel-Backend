<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {

        $user = $this->userService->getAll();

        return new UserResource(true, 'List Data Users', $user);
    }


    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $this->userService->createUser($request->all());

        return new UserResource(true, 'User berhasil dibuat!', $user);
    }
    
    public function show($id) {
        $user = $this->userService->getOne($id);

        return new UserResource(true, 'Data User Ditemukan!', $user);
    }
}
