<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {

        // dd($request->all());
        try {
            // Validate the request
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'message' => 'No image file provided',
                    'errors' => ['image' => ['Please select an image to upload']]
                ], 422);
            }

            $file = $request->file('image');

            // Generate a unique filename with original extension
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('public/images', $filename);

            // Get public URL
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getClientMimeType(),
                    'path' => $path,
                    'url' => $url,
                    'storage_path' => str_replace('public/', '', $path)
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

//=============================================================




















// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;

// class ImageUploadController extends Controller
// {
//     public function upload(Request $request)
//     {
//         // return response()->json([
//         //     'message' => 'Image upload endpoint',
//         //     'data' => $request->all(),
//         //     'file' => $request->file('image'),
//         //     'file_name' => $request->file('image')->getClientOriginalName(),
//         //     'file_size' => $request->file('image')->getSize(),
//         //     'file_type' => $request->file('image')->getClientMimeType(),
//         //     'file_extension' => $request->file('image')->getClientOriginalExtension(),
//         //     'file_path' => $request->file('image')->store('public/images'),
//         //     'file_url' => Storage::url($request->file('image')->store('public/images')),
//         // ], 200);
//         try {
//             // Validate the request
//             // $request->validate([
//             //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:248', // Max 2MB
//             // ]);

//             // Check if the request has a file
//             return response()->json([
//                 'message' => 'Image upload endpoint',
//                 'data' => $request->all(),
//                 'file' => $request->file('image'),
//                 'file_name' => $request->file('image')->getClientOriginalName(),
//                 'file_size' => $request->file('image')->getSize(),
//                 'file_type' => $request->file('image')->getClientMimeType(),
//                 'file_extension' => $request->file('image')->getClientOriginalExtension(),
//                 'file_path' => $request->file('image')->store('public/images'),
//                 'file_url' => Storage::url($request->file('image')->store('public/images')),
//             ], 200);



//             // if ($request->hasFile('image')) {
//             //     // $file = $request->file('image');
//             //     $image = $request->image;
//             //     $filename = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();
//             //     $path = $image->storeAs('public/images', $filename);
//             //     $url = Storage::url($path);
//             //     return response()->json([
//             //         'message' => 'Image uploaded successfully',
//             //         'path' => $url,
//             //     ], 200);
//             // } else {
//             //     return response()->json([
//             //         'message' => 'No image file found in the request',
//             //     ], 400);
//             // }



//             // if ($request->hasFile('image')) {
//             //     $file = $request->file('image');
//             //     $path = $file->store('public/images');
//             //     return response()->json([
//             //         'message' => 'Image uploaded successfully',
//             //         'path' => $path,
//             //     ], 200);
//             // }


//             // // Get the uploaded file
//             // $file = $request->file('image');

//             // // Generate a unique filename
//             // $filename = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();

//             // // Store the file in storage/app/public/images
//             // $path = $file->storeAs('public/images', $filename);
//             // // Generate the URL for the stored image
//             // $url = Storage::url($path);

//             // return response()->json([
//             //     'message' => 'Image uploaded successfully',
//             //     'path' => $url,
//             // ], 200);


//         } catch (\Exception $e) {

//             return response()->json([
//                 'message' => 'Failed to upload image',
//                 'error' => $e->getMessage(),
//             ], 500);
//         }
//     }
// }
