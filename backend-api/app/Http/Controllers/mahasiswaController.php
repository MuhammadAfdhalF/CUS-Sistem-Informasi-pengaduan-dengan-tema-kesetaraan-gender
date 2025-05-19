<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mahasiswaController extends Controller
{
    public function index() {
        //get data from table mahasiswas
        $mahasiswas=mahasiswa::latest()->get();
        //make response JSON
        return response()->json([ 'success'=> true,
            'message'=> 'List Data mahasiswa',
            'data'=> $mahasiswas], 200);
    }

    /**
* show
*
* @param mixed $id
* @return void
*/
    public function show($id) {
        //find mahasiswa by ID

        $mahasiswa=mahasiswa::findOrfail($id);
        //make response JSON
        return response()->json([ 'success'=> true,
            'message'=> 'Detail Data mahasiswa',
            'data'=> $mahasiswa], 200);
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
                'nim'=> 'required','email'=> 'required','kelas'=> 'required'
                ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $mahasiswa=mahasiswa::create([ 'nama'=> $request->nama,
            'nim'=> $request->nim,'email'=> $request->email,'kelas'=> $request->kelas]);

        //success save to database
        if($mahasiswa) {
            return response()->json([ 'success'=> true,
                'message'=> 'mahasiswa Created',
                'data'=> $mahasiswa], 201);
        }

        //failed save to database
        return response()->json([ 'success'=> false,
            'message'=> 'mahasiswa Failed to Save',

            ], 409);
    }

    /**
* update
*
* @param mixed $request
* @param mixed $mahasiswa
* @return void
*/
    public function update(Request $request, $id) {
    //set validation
    $validator=Validator::make($request->all(), [
        'nama'=> 'required',
        'nim'=> 'required',
        'email'=> 'required',
        'kelas'=> 'required',

            ]);

    //response error validation
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    //find kelas by ID
    $mahasiswa=mahasiswa::findOrFail($id);

    if($mahasiswa) {
        //update mahasiswa
        $mahasiswa->update([
            'nama'=> $request->nama,
            'nim'=> $request->nim,
            'email'=> $request->email,
            'kelas'=> $request->kelas,
        ]);
        return response()->json([ 'success'=> true,
            'message'=> 'mahasiswa Updated',
            'data'=> $mahasiswa], 200);
    }

    //data mahasiswa not found
    return response()->json([ 'success'=> false,
        'message'=> 'mahasiswa Not Found',
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
    $post=mahasiswa::findOrfail($id);

    if($post) {
        //delete post
        $post->delete();
        return response()->json([ 'success'=> true,
            'message'=> 'mahasiswa Deleted',
            ], 200);
    }

    //data post not found
    return response()->json([ 'success'=> false,
        'message'=> 'mahasiswa Not Found',
        ], 404);
    }
}
