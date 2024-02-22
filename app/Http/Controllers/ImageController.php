<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LikeFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        // Simpan gambar ke penyimpanan dan dapatkan pathnya
        $imagePath = $request->file('image')->store('public/images');

        // Simpan informasi tentang gambar ke basis data
        $image = new Image([
            'title' => $request->get('title'),
            'image_path' => $imagePath,
        ]);
        $image->save();

        return redirect('/images')->with('success', 'Image uploaded successfully');
    }
    public function delete($id)
    {
        // Cari gambar berdasarkan ID
        $image = Image::findOrFail($id);

        // Hapus gambar dari penyimpanan
        Storage::delete($image->image_path);

        // Hapus gambar dari database
        $image->delete();

        // Redirect atau memberikan respons sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with('success', 'Image deleted successfully');
    }
    public function like(Request $request, Image $image)
    {
        // Pastikan pengguna belum memberikan "like" sebelumnya
        if (!LikeFoto::where('users_id', auth()->id())->where('foto_id', $image->id)->exists()) {
            // Tambahkan entri baru ke dalam tabel like_foto
            LikeFoto::create([
                'users_id' => auth()->id(),
                'foto_id' => $image->id,
                'tanggal_like' => now(),
            ]);

            // Update jumlah "likes" di tabel images
            $image->increment('likes');

            // Simpan perubahan ke dalam basis data
            $image->save();
        }

        return redirect()->back(); // Redirect kembali ke halaman setelah memberikan "like"
    }
}
