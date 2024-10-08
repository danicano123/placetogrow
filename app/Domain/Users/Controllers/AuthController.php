<?php

namespace App\Domain\Users\Controllers;

use App\Domain\Users\Requests\LoginRequest;
use App\Domain\Users\Requests\RegisterUserRequest;
use App\Domain\Users\Models\User;
use App\Domain\Users\Services\RolePermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API de Ejemplo",
 *     description="Documentación del API de Ejemplo usando Swagger",
 *     @OA\Contact(
 *         email="admin@ejemplo.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class AuthController
{
    protected $rolePermissionService;

    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     tags={"Auth"},
     *     summary="Registrar un nuevo usuario",
     *     description="Registro de un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario registrado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Datos inválidos")
     *         )
     *     )
     * )
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            // Crea el usuario con los datos obligatorios y opcionales
            $userData = array_filter([
                'first_name' => $request->first_name,
                'second_name' => $request->second_name,  // Opcional
                'first_surname' => $request->first_surname,
                'second_surname' => $request->second_surname,  // Opcional
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user = User::create($userData);

            // Asigna el rol al usuario
            $this->rolePermissionService->assignRoleToUser($user, 'user');

            // Obtén el nombre del rol
            $role = $this->rolePermissionService->showUserRole($user);

            // Genera el token JWT
            $token = JWTAuth::fromUser($user);

            // Respuesta JSON con el usuario, rol y token
            return response()->json(compact('user', 'role', 'token'), 201);
        } catch (\Exception $e) {
            Log::error('Error registering user: ' . $e->getMessage());
            return response()->json(['error' => 'Error registering user'], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     tags={"Auth"},
     *     summary="Iniciar sesión",
     *     description="Iniciar sesión de un usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Credenciales inválidas")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            // Obtén el usuario autenticado
            $user = JWTAuth::user();

            // Obtén el nombre del rol del usuario
            $role = $this->rolePermissionService->showUserRole($user);

            // Respuesta JSON con el usuario, rol y token
            return response()->json([
                'user' => $user,
                'role' => $role,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error logging in user: ' . $e->getMessage());
            return response()->json(['error' => 'Error logging in user'], 500);
        }
    }
}
