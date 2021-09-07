<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdmin;
use App\Http\Requests\UpdateAdmin;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiDesignTrait;

     /**
     * @OA\Post(
     * path="/api/admin/login",
     * summary="Login",
     * description="Login Admin and Create token",
     * operationId="login",
     * tags={"Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store admin data",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *     @OA\Property(property="email", type="email", format="email", example="admin@gmail.com"),
     *     @OA\Property(property="password", type="password", format="email", example="123456789"),
     *        )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="Admin", type="object", ref="#/components/schemas/Admin"),
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Invalid Credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid Credentials"),
     *    )
     * )
     * )
     */
    public function login(Request $request){
        $data = $request->validate([
                 'email' => 'required|email',
                 'password'=>'required'
              ]);
       $admin= auth()->guard('admin')->attempt($data);
       $admin = Admin::where('email',$request->email)->first();
        if(!$admin){
            return $this->ApiResponse(422,'Admin Does Not Exist');
        }
        if(Hash::check($request->password, $admin->password) === false){
            return $this->ApiResponse(422,'Invalid Credentials');
        }
        $adminToken = $admin->createToken('token')->plainTextToken;
        return $this->ApiResponse(200,'You Are Login',null, $adminToken);
  }
  /**
     * @OA\Post(
     * path="/api/admin/create",
     * summary="create admin",
     * description="create new admin ",
     * operationId="store",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="store new Admin name",
     *    @OA\JsonContent(
     *       required={"name","email","password"},
     *     @OA\Property(property="name", type="string", example="Admin"),
     *     @OA\Property(property="email", type="string", format="email", example="Admin@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="role", type="integer" ,example="Admin"),
     *        ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Admin created Successfully")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Enter Valid Data")
     *        )
     *     )
     * )
     *
     */
  public function create(StoreAdmin $request){
     $this->authorize('create',Admin::class);
    $admin = Admin::create([
             'name'=>$request->name,
             'email'=>$request->email,
             'password'=>Hash::make($request->password)
         ]);
         $admin->assignRole($request->role);
   return $this->ApiResponse(200,"Admin Added Successfully",null,$admin);
 }
     /**
     * @OA\post (
     * path="/api/admin/{admin}",
     * summary="update existing admin",
     * description="update admin",
     * operationId="update",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="admin",
     *          description="admin id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="update admin ",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *     @OA\Property(property="name", type="string", example="Admin"),
     *     @OA\Property(property="email", type="string", format="email", example="Admin@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="role", type="integer" ,example="admin"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Admin updated")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="validation error", type="string", example="Sorry,Enter Valid Data")
     *        )
     *     )
     * )
     *
     */
    public function update(Admin $admin, UpdateAdmin $request)
    { 
       $this->authorize('edit',$admin);
        $admin ->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
       ]);
            $admin->assignRole($request->role);
        return $this->ApiResponse(200,'Admin Updated successfully',null,$admin);
    }   
    
     /**
     * @OA\Post (
     * path="/api/admin/delete/{admin}",
     * summary="Delete Admin",
     * description="Delete Admin",
     * operationId="AdminDelete",
     * tags={"Admin"},
     * security={ {"sanctum": {} }} ,
     * @OA\Parameter(
     *    description="ID of Admin",
     *    in="path",
     *    name="admin",
     *    required=true,
     *    example="2",
     * @OA\Schema(
     *       type="integer",
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Admin Deleted successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="text", example="Admin deleted successfully"),
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object"),
     *        )
     *     )
     * )
     */
    public function delete(Admin $admin){
        $this->authorize('delete',$admin);
        $admin->delete();
        return $this->ApiResponse(200,'Admin Deleted successfully');
      }

      /**
     * @OA\Post(
     * path="/api/admin/logout",
     * summary="Logout",
     * description="Logout Admin and delete token",
     * operationId="logout",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     @OA\Property(property="message", type="string", example="Logedout"),
     *    ),
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Logedout"),
     *    )
     * )
     * )
     */

    public function logout()
    {
        $admin = auth('sanctum')->user();
        $admin->tokens()->where('id', $admin->currentAccessToken()->id)->delete();
        return $this->ApiResponse(200,' You Are Logged Out');
    }
}
