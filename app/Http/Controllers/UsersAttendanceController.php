<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;


class UsersAttendanceController extends Controller
{
    /**
     * Display the face capture form.
     */
    public function captureForm()
    {
        return view('face_register_form');
    }

    /**
     * Register the user's face using a Python script.
     */
    public function registerFace(Request $request)
    {
        $user_id = $request->input('user_id');

        // Run the Python script
        $pythonScriptPath = public_path('python/capture_face_image.py');
        $command = 'python ' . escapeshellarg($pythonScriptPath) . ' ' . escapeshellarg($user_id);

        Log::info("Running Python script: $command");

        $output = shell_exec($command);
        Log::info("Python output: $output");

        $output_json = json_decode($output, true);

        if ($output_json && isset($output_json['status']) && $output_json['status'] === 'success') {
            $image_filename = $output_json['image_filename'];
            $image_path = public_path('face_images/' . $image_filename);

            // Ensure the image exists after capture
            if (!file_exists($image_path)) {
                Log::error("Image file not found after capture: $image_path");
                return response()->json(['message' => 'Image capture failed.']);
            }

            // Insert into database
            DB::table('users_attendance')->insert([
                'user_id' => $user_id,
                'image_filename' => $image_filename,
                'name' => 'Captured User', // Optional: Replace with actual name if available
            ]);

            return response()->json([
                'message' => 'Face image captured and attendance saved!',
                'user_id' => $user_id,
                'image_filename' => $image_filename,
            ]);
        }

        // Handle failure
        Log::error('Failed to process face capture: ' . $output);
        return response()->json(['message' => 'Face capture failed'], 500);
    }

    /**
     * Train the face recognition model.
     */
    public function trainFaceRecognitionModel()
    {
        $scriptPath = public_path('python/train_faces.py');
        $command = 'python ' . escapeshellarg($scriptPath);

        Log::info("Training face recognition model with: $command");

        $output = shell_exec($command);
        Log::info("Training output: $output");

        if (file_exists(public_path('python/trainer.yml'))) {
            return response()->json([
                'message' => 'Training complete! Model saved successfully.',
                'output' => $output
            ]);
        }

        return response()->json([
            'message' => 'Training failed. trainer.yml not found.',
            'output' => $output
        ], 500);
    }

    /**
     * Recognize face using the trained model.
     */

     
  
public function recognizeFace(Request $request)
{
    $imageData = $request->input('image');

    if (!$imageData) {
        return response()->json([
            'status' => 'error',
            'message' => 'No image uploaded.'
        ]);
    }

    // Decode base64 image (data:image/jpeg;base64,/...)
    if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $extension = strtolower($type[1]); // jpg, png etc.

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid image type.'
            ]);
        }

        $imageData = base64_decode($imageData);
        if ($imageData === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Base64 decode failed.'
            ]);
        }
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid image data format.'
        ]);
    }

    // Save decoded image to public/face_images
    $filename = 'webcam_input_' . time() . '.' . $extension;
    $imagePath = public_path('face_images/' . $filename);
    file_put_contents($imagePath, $imageData);

    // Define Python script path
    $pythonScriptDir = public_path('python');
    $pythonScriptName = 'recognize_face.py';
    $command = 'cd ' . escapeshellarg($pythonScriptDir) . ' && python ' . escapeshellarg($pythonScriptName) . ' ' . escapeshellarg($imagePath);

    // Log command for debugging
    Log::info("Running face recognition command: $command");

    // Execute command
    $output = shell_exec($command);

    if (!$output) {
        return response()->json([
            'status' => 'error',
            'message' => 'Python script returned no output.'
        ]);
    }

    // Decode JSON result from Python
    $result = json_decode($output, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to parse JSON response from Python.',
            'raw_output' => $output
        ]);
    }

    return response()->json($result);
}
     
    
}
