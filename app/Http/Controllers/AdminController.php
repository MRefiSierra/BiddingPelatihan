<?php

namespace App\Http\Controllers;

use App\Models\pelatihanInstruktur;
use App\Models\Pelatihans;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;

class AdminController extends Controller
{
    // Admin (Create User)

    public function managementUser()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.management-user', ['users' => $users]);
    }

    public function inputUser()
    {
        return view('admin.add-user');
    }

    public function storeUser(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        $user = User::Create([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect()->route('managementUser.view')->with('success', 'User has been added');
    }

    public function editUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('managementUser.view')->with('error', 'User not found');
        }


        return view('admin.edit-user', ['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'nullable',
        ]);

        // $user = User::find($id);
        // // Update user properties
        // $user->name = $validation['nama'];
        // $user->email = $validation['email'];
        // $user->role = $validation['role'];



        // // Save the user
        // $user->save();

        $user = User::findOrFail($id);

        $user->name = $request->input('nama');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        return redirect()->route('managementUser.view')->with('success', 'User has been updated');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('managementUser.view')->with('success', 'User has been deleted');
    }

    public function userDetail($id)
    {
        $user = User::find($id);
        return view('admin.user-detail', ['user' => $user]);
    }

    public function deleteInstruktur($id)
    {
        $instruktur = pelatihanInstruktur::find($id);
        $instruktur->delete();
        return redirect()->route('admin.pelatihan')->with('success', 'user has been deleted');
    }

    public function calendarPelatihan(){
        $pelatihans = Pelatihans::with('relasiDenganInstruktur.user', 'relasiDenganRangeTanggal')->get();
        $events = [];

        foreach ($pelatihans as $pelatihan){
            $events[] = [
                'id' => $pelatihan->id,
                'title' => $pelatihan->nama,
                'start' => $pelatihan->relasiDenganRangeTanggal->tanggal_mulai,
                'end' => $pelatihan->relasiDenganRangeTanggal->tanggal_selesai,
                'quota_instruktur' => $pelatihan->kuota_instruktur,
                'instrukturs' => $pelatihan->instrukturs->map(function ($instruktur) {
                    return $instruktur->user->name;
                })->toArray()
            ];
        }


        return response()->json($events);
    }
}
