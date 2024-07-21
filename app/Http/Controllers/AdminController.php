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

    public function userCalendar($userId)
    {
        // Ambil pelatihan yang terkait dengan instruktur berdasarkan userId
        $events = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($userId) {
            $query->where('id_instruktur', $userId);
        })
            ->with(['relasiDenganInstruktur.user', 'relasiDenganRangeTanggal'])
            ->get()
            ->map(function ($pelatihan) {

                $start = $pelatihan->relasiDenganRangeTanggal->tanggal_mulai;
                $end = $pelatihan->relasiDenganRangeTanggal->tanggal_selesai;
                $end = date('Y-m-d', strtotime($end . ' +1 day'));

                $instrukturs = $pelatihan->relasiDenganInstruktur->map(function ($pelatihanInstruktur) {
                    return $pelatihanInstruktur->user ? $pelatihanInstruktur->user->name : 'Unknown';
                })->toArray();

                // Generate warna acak
                $backgroundColor = $this->generateRandomColor();
                $textColor = $this->getContrastColor($backgroundColor);

                return [
                    'title' => $pelatihan->nama,
                    'start' => $start,
                    'end' => $end,
                    'instrukturs' => $instrukturs,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $backgroundColor, // Jika ingin border juga memiliki warna yang sama
                    'color' => $textColor, // Warna teks yang kontras
                ];
            });

        return response()->json($events);
    }

    public function deleteInstruktur($id)
    {
        // Temukan instruktur yang akan dihapus
        $instruktur = pelatihanInstruktur::find($id);

        // Cek apakah instruktur ditemukan
        if ($instruktur) {
            // Temukan pelatihan yang terkait
            $pelatihan = Pelatihans::find($instruktur->id_pelatihan);

            // Tambahkan kuota instruktur pada pelatihan yang terkait
            if ($pelatihan) {
                $pelatihan->kuota_instruktur += 1; // Tambahkan kuota instruktur
                $pelatihan->save();
            }

            // Hapus instruktur
            $instruktur->delete();

            return redirect()->route('pelatihan')->with('success', 'Instruktur telah dihapus dan kuota telah diperbarui.');
        } else {
            return redirect()->route('pelatihan')->with('error', 'Instruktur tidak ditemukan.');
        }
    }


    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    // Fungsi untuk menentukan warna teks kontras
    private function getContrastColor($hex)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Menggunakan rumus luminansi untuk menentukan kontras
        $contrast = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($contrast > 127) ? '#000000' : '#FFFFFF'; // Hitam jika terang, putih jika gelap
    }

    public function calendarPelatihan()
    {
        $events = Pelatihans::with(['relasiDenganInstruktur.user', 'relasiDenganRangeTanggal'])->get()->map(function ($pelatihan) {

            $start = $pelatihan->relasiDenganRangeTanggal->tanggal_mulai;
            $end = $pelatihan->relasiDenganRangeTanggal->tanggal_selesai;

            // Pastikan end diatur satu hari setelah tanggal selesai
            $end = date('Y-m-d', strtotime($end . ' +1 day'));
            // Generate warna acak
            $backgroundColor = $this->generateRandomColor();
            $textColor = $this->getContrastColor($backgroundColor);


            // dd($pelatihan->relasiDenganInstruktur->map(function ($pelatihanInstruktur) {
            //     return $pelatihanInstruktur->user->name;
            // }));

            $instrukturs = $pelatihan->relasiDenganInstruktur->map(function ($pelatihanInstruktur) {
                // Pastikan relasi `user` ada dan dapat diakses
                return $pelatihanInstruktur->user ? $pelatihanInstruktur->user->name : 'Unknown';
            })->toArray();

            return [
                'title' => $pelatihan->nama,
                'start' => $start,
                'end' => $end,
                'instrukturs' => $instrukturs,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $backgroundColor, // Jika ingin border juga memiliki warna yang sama
                'color' => $textColor, // Warna teks yang kontras
            ];
        });

        return response()->json($events);
    }
}
