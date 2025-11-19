<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObyekWisata;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use App\Models\Berita;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obyekWisatas = ObyekWisata::all();
        $paketWisatas  = PaketWisata::all();
        $penginapans   = Penginapan::all();
        $beritas       = Berita::orderBy('tgl_post','desc')->get();

        return view('fe.home', compact('obyekWisatas','paketWisatas','penginapans','beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
