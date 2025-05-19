<?php

namespace App\Http\Controllers;

use App\Models\pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pelaporanController extends Controller
{
    public function index()
    {
        //get data from table posts
        $posts = pelaporan::latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data' => $posts
        ], 200);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID

        $post = Pelaporan::findOrfail($id);
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data' => $post
        ], 200);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nim' => 'required', 
            'nohp' => 'required', 
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'deskripsi' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //upload image
        $image = $request->file('bukti');
        $image->storeAs('public/bukti', $image->hashName());

        //save to database
        $pelaporan = pelaporan::create([
            'nama' => $request->nama,
            'nim' => $request->nim, 
            'nohp' => $request->nohp, 
            'jenis' => $request->jenis, 
            'deskripsi' => $request->deskripsi, 
            'bukti' => $image->hashname(),
        ]);

        //success save to database
        if ($pelaporan) {
            return response()->json([
                'success' => true,
                'message' => 'pelaporan Created',
                'data' => $pelaporan
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',

        ], 409);
    }

    /**
     * update
     *
     * @param mixed $request
     * @param mixed $post
     * @return void
     */
    public function update(Request $request, Pelaporan $post)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $pelaporan = pelaporan::findOrFail($post->id);

        if ($pelaporan) {
            //update pelaporan
            $pelaporan->update([
                'title' => $request->title,
                'content' => $request->content
            ]);
            return response()->json([
                'success' => true,
                'message' => 'pelaporan Updated',
                'data' => $pelaporan
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $post = Pelaporan::findOrfail($id);

        if ($post) {
            //delete post
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
}
