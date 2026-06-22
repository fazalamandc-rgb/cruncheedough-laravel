<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaceRecognitionController extends Controller
{
    public function recognize()
    {
        $command = 'python public/python/recognize_face.py';
        exec($command, $output);
        $json = implode('', $output);
        $response = json_decode($json, true);

        if ($response && $response['status'] === 'success') {
            return response()->json([
                'message' => 'Face recognized successfully!',
                'user_id' => $response['user_id'],
                'image_filename' => $response['image_filename']
            ]);
        } else {
            return response()->json([
                'message' => $response['message'] ?? 'Unknown error occurred',
            ], 400);
        }
    }
}
