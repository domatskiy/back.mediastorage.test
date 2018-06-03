<?php

namespace App\Http\Controllers;

use App\MediaStorage\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $files = [];

        $query = Files::select([
            'id',
            'user',
            'email',
            'file',
            'ext',
            'description',
            ])
            ->orderBy('id', 'desc');

        # TODO add filter $query = $query->where()

        $perPage = (int)$request->get('limit') ? (int)$request->get('limit') : 100;
        $page = (int)$request->get('page') ? (int)$request->get('page') : 1;

        $files = $query->paginate($perPage, null, 'page', $page);
        #$files->withPath(route('admin.index'));

        return view('admin.list', [
            'files' => $files,
            #'files' => $files->items(),
            #'count' => $files->total(),
        ]);
    }

    # GET
    public function edit($id, Request $request){

        $query = Files::select([
            'id',
            'user',
            'email',
            'file',
            'ext',
            'description',
            ])
            ->orderBy('id', 'desc')
            ->where('id', '=', (int)$id);

        $file = $query->first();

        if(!$file)
            abort(404);


        return view('admin.edit', [
            'data' => $file,
            'back' => ''
        ]);
    }

    # PUT
    public function update($id, Request $request){

        Log::debug('update '.$id);

        $file = Files::find($id);

        if(!$file)
            abort(404);

        if ($request->get('description') !== null)
            $file->description = $request->get('description');

        Log::debug('desc '.$request->get('description'));

        $file->update();

        Log::debug('redirect to '.route('admin.edit', ['id' => $file->id]));

        return redirect()->route('admin.edit', ['id' => $file->id]);
    }

    # DELETE
    public function destroy($id, Request $request)
    {
        Log::debug('destroy '.$id);

        $file = Files::find($id);

        if(!$file)
            abort(404);

        $file->destroy($id);

        return redirect()->route('admin.index');
    }
}
