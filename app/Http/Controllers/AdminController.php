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
        return redirect()->route('managementUser.view')->with('success', 'User berhasil dihapus');
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
        $events = Pelatihans::with(['relasiDenganInstruktur','relasiDenganRangeTanggal'])->get()->map(function($pelatihan) {

            $start = $pelatihan->relasiDenganRangeTanggal->tanggal_mulai;
            $end = $pelatihan->relasiDenganRangeTanggal->tanggal_selesai;

            // Pastikan end diatur satu hari setelah tanggal selesai
            $end = date('Y-m-d', strtotime($end . ' +1 day'));

            return [
                'title' => $pelatihan->nama,
                'start' => $start,
                'end' => $end,
                'instrukturs' => $pelatihan->relasiDenganInstruktur->pluck('name')->toArray()
            ];
        });

        return response()->json($events);
    }
}
