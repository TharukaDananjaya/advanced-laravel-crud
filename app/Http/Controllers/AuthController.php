<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/**
 * @OA\PathItem(
 *     path="/api"
 * )
 *
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel API Documentation",
 *      description="API documentation for the Advanced Laravel CRUD system",
 *      @OA\Contact(
 *          email="admin@example.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Laravel API Server"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      operationId="registerUser",
     *      tags={"Authentication"},
     *      summary="Create a new user",
     *      description="Adds a new user",
     *      security={},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","email","password","role"},
     *              @OA\Property(property="name", type="string", example="New Product"),
     *              @OA\Property(property="email", type="email", example="example@gmail.com"),
     *              @OA\Property(property="password", type="password", example="password"),
     *              @OA\Property(property="role", type="string", example="User", enum={"Admin", "User"})
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User registered successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:Admin,User'
        ]);
        $role = Role::where('name', $request->role)->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user
        ], 201);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Login a user",
     *      description="Authenticate a user",
     *      security={},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="email", example="example@gmail.com"),
     *              @OA\Property(property="password", type="password", example="password"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Login successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user
        ]);
    }
    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      summary="Logout user",
     *      description="Logout Authenticated user",
     *      security={{ "sanctum": {} }},
     *      @OA\Response(
     *          response=201,
     *          description="Logout successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/user",
     *      operationId="getUser",
     *      tags={"Authentication"},
     *      summary="Get User",
     *      description="Get Authenticated user",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
     * )
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
