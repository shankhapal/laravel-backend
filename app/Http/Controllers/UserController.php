<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password)
            ]);
            return response()->json('successfully created');
        } catch(QueryException $e){
        // Check if the exception is due to a duplicate entry (unique constraint violation)
             if ($e->errorInfo[1] === 1062) { // 1062 is the MySQL error code for duplicate entry
                return response()->json('Email already exists', 422); // Return a 422 Unprocessable Entity status code with an error message
            } else {
            // Handle other database exceptions here
                return response()->json('An error occurred while creating the user', 500); // Return a 500 Internal Server Error status code with a generic error message
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            // If the user is not found, you can return a 404 response or handle it as needed
            return response()->json(['message' => 'User not found'], 404);
        }

        // Display the user's information (you can customize this part)
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return response()->json(User::whereId($id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id){
       
        $user = User::whereId($id)->first();

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return response()->json('success');
     }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the user by id
        $user = User::find($id);

        //check if user is exists
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }

        $user->delete();
        return response()->json(['message'=>'User deleted successfully']);

    }
}