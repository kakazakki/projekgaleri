<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

        $imagePath = $request->file('image')->store('public/images');
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
    public function like(Image $image)
    {
        $image->increment('likes'); // Increment the likes count for the image
        return redirect()->back(); // Redirect back to the page after liking
    }
}
