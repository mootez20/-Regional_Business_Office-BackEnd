<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Document::all();
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
        $Documents = new Document();

        $request->validate([
            'sujet'=>'required',
            'contenu'=>'required',
            'fichier'=>'required',
            'categorie_id'=>'required',
            'organisme_id'=>'required'


        ]);

        $Documents->sujet = $request->input('sujet');
        $Documents->contenu = $request->input('contenu');
        $Documents->fichier = $request->input('fichier');
        $Documents->categorie_id = $request->input('categorie_id');
        $Documents->organisme_id = $request->input('organisme_id');




        $data =  $Documents->save();
        if(!$data){
            return response()->json([
                'status' =>400,
                'error' =>'something went wrong'
            ]);
        } 
        else {
            return response()->json([
                'status' =>200, 
                $Documents ,
                'message '=>'Data Successfully saved'
           
         
        ]);

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
        return Document::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Document = Document::find($id);

        $Document->sujet = $request->input('sujet');
        $Document->contenu = $request->input('contenu');
        $Document->fichier = $request->input('fichier');
        $Document->categorie_id = $request->input('categorie_id');
        $Document->organisme_id = $request->input('organisme_id');

        $Document->save();

        return response()->json($Document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Document::destroy($id);
    }
}
