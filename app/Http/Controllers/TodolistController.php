<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function index()
    {
        $todolists = Todolist::all();
        return view('home', compact('todolists'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required'
        ]);

        Todolist::create($data);
        return back();
    }

    public function destroy(Todolist $todolist)
    {
        $todolist->delete();
        return back();
    }

    public function change(Todolist $todolist)
    {
        if ($todolist->status == 1) {
            $todolist->status = 2;
            $todolist->updated_at = now();
        } 
        elseif ($todolist->status == 2) {
            $todolist->status = 1;
            $todolist->updated_at = now();
        } 
        else {
            return back()->withErrors(['status' => 'Invalid status']);
        }
    
        $todolist->save();
        return back();
    }
}
