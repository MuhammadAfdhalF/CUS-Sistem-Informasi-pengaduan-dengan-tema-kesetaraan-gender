<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class dosenController extends Controller
{
    public function index() {
        //get data from table posts
        $posts=dosen::latest()->get();
        //make response JSON
        return response()->json([ 'success'=> true,
            'message'=> 'List Data Post',
            'data'=> $posts], 200);
    }

    /**
* show
*
* @param mixed $id
* @return void
*/
    public function show($id) {
        //find post by ID

        $post=dosen::findOrfail($id);
        //make response JSON
        return response()->json([ 'success'=> true,
            'message'=> 'Detail Data Post',
            'data'=> $post], 200);
    }

    /**
* store
*
* @param mixed $request
* @return void
*/
    public function store(Request $request) {
        //set validation
        $validator=Validator::make($request->all(), [ 'nama'=> 'required',
                'nip'=> 'required','email'=> 'required','prodi'=> 'required'
                ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $dosen=dosen::create([ 'nama'=> $request->nama,
            'nip'=> $request->nip,'email'=> $request->email,'prodi'=> $request->prodi]);

        //success save to database
        if($dosen) {
            return response()->json([ 'success'=> true,
                'message'=> 'dosen Created',
                'data'=> $dosen], 201);
        }

        //failed save to database
        return response()->json([ 'success'=> false,
            'message'=> 'Post Failed to Save',

            ], 409);
    }

    /**
* update
*
* @param mixed $request
* @param mixed $post
* @return void
*/
public function update(Request $request, $id) {
    //set validation
    $validator=Validator::make($request->all(), [
        'nama'=> 'required',
        'nip'=> 'required',
        'email'=> 'required',
        'prodi'=> 'required',

            ]);

    //response error validation
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    //find kelas by ID
    $dosen=dosen::findOrFail($id);

    if($dosen) {
        //update dosen
        $dosen->update([
            'nama'=> $request->nama,
            'nip'=> $request->nip,
            'email'=> $request->email,
            'prodi'=> $request->prodi,
        ]);
        return response()->json([ 'success'=> true,
            'message'=> 'dosen Updated',
            'data'=> $dosen], 200);
    }

    //data dosen not found
    return response()->json([ 'success'=> false,
        'message'=> 'dosen Not Found',
        ], 404);
    }

    /**
* destroy
*
* @param mixed $id
* @return void
*/
    public function destroy($id) {
    //find post by ID
    $post=dosen::findOrfail($id);

    if($post) {
        //delete post
        $post->delete();
        return response()->json([ 'success'=> true,
            'message'=> 'dosen Deleted',
            ], 200);
    }

    //data post not found
    return response()->json([ 'success'=> false,
        'message'=> 'dosen Not Found',
        ], 404);
    }
}