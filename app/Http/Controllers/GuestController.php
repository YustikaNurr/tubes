<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Guest List';

        // RAW SQL QUERY
        $guest = DB::select('
            select *, guest.id as guest_id from guest
        ');

        return view('guest.index', [
            'pageTitle' => $pageTitle,
            'guest' => $guest
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Guest';

        return view('guest.create', compact('pageTitle'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'contact' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // INSERT QUERY
        DB::table('guest')->insert([
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        return redirect()->route('guest.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Guest Detail';

        // RAW SQL QUERY untuk tabel guest
        $guest = collect(DB::select('
        select *, guest.id as guest_id
        from guest
        where guest.id = ?
    ', [$id]))->first();

        return view('guest.show', compact('pageTitle', 'guest'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $guest = DB::table('guest')->where('id', $id)->first();
        if (!$guest) {
            abort(404);  // atau return redirect()->route('guest.index')->with('error', 'Guest not found');
        }

        $pageTitle = 'Edit Guest'; // Tambahkan ini
        return view('guest.edit', compact('guest', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar.',
            'numeric' => 'Isi :attribute dengan angka.'
        ];

        // Validasi
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'contact' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data di tabel guest
        DB::table('guest')
            ->where('id', $id)
            ->update([
                'firstname' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'contact' => $request->contact,
            ]);
        return redirect()->route('guest.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // QUERY BUILDER
        DB::table('guest')
            ->where('id', $id)
            ->delete();

        return redirect()->route('guest.index');

    }
}
