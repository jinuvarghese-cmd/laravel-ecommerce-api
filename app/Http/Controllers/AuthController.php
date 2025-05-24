<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Register a new user
     *
     * @group Authentication
     * 
     * @bodyParam name string required Name of the user. Example: John Doe
     * @bodyParam email string required Email address. Example: john@example.com
     * @bodyParam password string required Password. Example: password123
     * @bodyParam password_confirmation string required Confirmed password. Example: password123
     * @bodyParam role string optional Role of the user. Allowed values: "user", "admin". Defaults to "user". Example: user
     *
     * @response 201 {
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "role": "user" // or "admin"
     *   },
     *   "token": "plainTextTokenHere"
     * }
     */

    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();
        $result = $this->authService->register($fields);

        $user = $result['user'];
        $token = $result['token'];

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ], 201);
    }

        /**
     * Login a user
     *
     * @group Authentication
     * 
     * @bodyParam email string required Email address. Example: john@example.com
     * @bodyParam password string required Password. Example: password123
     *
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com"
     *     "role": "user" // or "admin"
     *   },
     *   "token": "plainTextTokenHere"
     * }
     */
    public function login(LoginRequest $request)
    {
        $fields = $request->validated();

        $result = $this->authService->login($fields);

        if (!$result) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = $result['user'];
        $token = $result['token'];

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    /**
     * Logout the user
     *
     * @group Authentication
     * 
     * @authenticated
     *
     * @response 200 {
     *   "message": "Logged out"
     * }
     */

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'Logged out']);
    }

        /**
     * Get authenticated user profile
     *
     * @group Authentication
     * 
     * @authenticated
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "john@example.com"
     *   "role": "user" // or "admin"
     * }
     */

    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }
}
