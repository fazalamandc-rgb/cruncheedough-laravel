<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\FscategorController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CartView;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodCateg;
// Home route
Route::get('/', function () {
    return view('index'); // Ensure 'index.blade.php' exists in 'resources/views'
});

// Login-related routes
Route::post('/proclog', [LoginController::class, 'processLog']);
Route::post('/procloadm', [AdminController::class, 'authenticate']);
Route::get('/login', [OrderController::class, 'showLoginForm'])->name('login');

Route::get('/loginb', [LoginController::class, 'showLoginForm'])->name('loginb');

// Order-related routes
Route::post('/add-to-cart', [OrderController::class, 'addToCart'])->name('add.to.cart');
Route::post('/fill-scourse', [OrderController::class, 'fillScourse'])->name('fill.scourse');
Route::post('/show-detail', [OrderController::class, 'showDetail'])->name('show.detail');
Route::get('/print-bill', [OrderController::class, 'printBill'])->name('print.bill');

// Exit route
Route::get('/exit', function () {
    // Add logic for session cleanup if needed
    return redirect('/'); // Redirect to homepage
})->name('exit');

// Food-related routes
Route::get('/foodsubcateg/{foodId}', [FscategorController::class, 'getFoodSubCategories'])->name('foodsubcateg');
Route::get('/get-food-items', [FoodController::class, 'getFoodItems']);

// Cart-related routes
Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/cart_view', [CartView::class, 'index'])->name('cart.view');
Route::delete('/cart/remove/{id}', [CartView::class, 'remove'])->name('cart.remove');
// PDF generation route


Route::get('/admlogin', function () {
    return view('admin_login');
})->name('admlogin');

Route::get('/mainpage', function () {
    return view('index');
})->name('mp');

Route::get('/mainadm', [AdminController::class, 'mainadm'])->name('mainadm');

// Route for main admin page

// Route for logout
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


// Display the list of food categories
Route::get('foods', [FoodCateg::class, 'index'])->name('foods.index');
Route::get('/category-foods-desserts', [FoodCateg::class, 'index'])->name('category.foods.desserts');
//here
use App\Http\Controllers\OptFoodDesserts;
// Resource routes for sub-category foods
//Route::get('/sub-category-foods-desserts', [OptFoodDesserts::class, 'index'])->name('sub.category.foods.desserts');
Route::get('/sub-category-foods-desserts', [OptFoodDesserts::class, 'index'])->name('subFoods.index');
Route::get('/food-sub-categ/create', [OptFoodDesserts::class, 'create'])->name('subFoods.create');
Route::get('/food-sub-categ/{id}', [OptFoodDesserts::class, 'edit'])->name('subFoods.edit');
Route::put('sub-foods/{id}', [OptFoodDesserts::class, 'update'])->name('subFoods.update');
Route::delete('/food-sub-categ/delete/{id}', [OptFoodDesserts::class, 'destroy'])->name('subFoods.delete');
//Route::get('/food-sub-categ/create', [OptFoodDesserts::class, 'create'])->name('subFoods.create');
Route::post('/food-sub-categ/store', [OptFoodDesserts::class, 'store'])->name('subFoods.store');
//to here


Route::get('fsc_edit/{id}', [FoodCateg::class, 'edit'])->name('foods.edit');
Route::post('fsc_update', [FoodCateg::class, 'update'])->name('foods.update');
Route::delete('fsc_delete/{id}', [FoodCateg::class, 'destroy'])->name('foods.delete');
Route::get('foods/create', [FoodCateg::class, 'create'])->name('foods.create');
Route::post('foods/store', [FoodCateg::class, 'store'])->name('foods.store');


Route::get('/generate-pdf', [PdfController::class, 'generatePdf'])->name('generate.pdf');


use App\Http\Controllers\OptFoodItems;
Route::get('food-items', [OptFoodItems::class, 'index'])->name('foodItems.index');
Route::get('food-items/create', [OptFoodItems::class, 'create'])->name('foodItems.create');
Route::post('food-items', [OptFoodItems::class, 'store'])->name('foodItems.store');
Route::get('food-items/{id}/edit', [OptFoodItems::class, 'edit'])->name('foodItems.edit');
Route::put('food-items/{id}', [OptFoodItems::class, 'update'])->name('foodItems.update');
Route::delete('food-items/{id}', [OptFoodItems::class, 'destroy'])->name('foodItems.destroy');
use App\Http\Controllers\CounterController;
Route::get('/counter', [CounterController::class, 'showcounter'])->name('counter');
Route::post('/counter/update', [CounterController::class, 'updateOrder'])->name('counter.update');


use App\Http\Controllers\KitchenCounterController;
// Display Kitchen Counter Orders
Route::get('/kitchen', [KitchenCounterController::class, 'showKitchenCounter'])->name('kitchen');
// Update Order Delivered Status
Route::post('/kitchen/update', [KitchenCounterController::class, 'updateOrderStatus'])->name('kitchen.update');


use App\Http\Controllers\OrderControllerEmail;
//use Illuminate\Support\Facades\Route;
Route::get('/send-email', [OrderControllerEmail::class, 'sendOrderEmail']);

//here 

Route::post('/counter/send-email', [CounterController::class, 'sendEmail'])->name('counter.sendEmail');
//to here

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
Route::get('/test-python', function () {
    try {
        // Full path to python.exe
        $pythonPath = 'C:\Users\HAIER\AppData\Local\Programs\Python\Python310\python.exe';
        $scriptPath = base_path('public/python/test_script.py');
        $process = new Process([$pythonPath, '--version']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['output' => $process->getOutput()]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});



use Illuminate\Support\Facades\Log;

Route::get('/add-numbers', function () {
    try {
        $pythonPath = 'C:\\Users\\HAIER\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
        $scriptPath = base_path('public\\python\\test_script.py');

        $num1 = 10;
        $num2 = 20;

        // Set PYTHONHASHSEED=0 in the process environment directly
        $process = new Process([$pythonPath, $scriptPath, $num1, $num2], null, [
            'PYTHONHASHSEED' => '0'
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

    return response()->json(['output' => trim($process->getOutput())]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/process-json', function () {
    try {
        $data = [
            'num1' => 10,
            'num2' => 20,
            'action' => 'add'
        ];

        $pythonPath = 'C:\\Users\\HAIER\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
        $scriptPath = base_path('public\\python\\process_json.py');

        // Pass JSON-encoded data to Python script
        $process = new Process([$pythonPath, $scriptPath, json_encode($data)], null, [
            'PYTHONHASHSEED' => '0'
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['output' => $process->getOutput()]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

//from here

use Illuminate\Http\Request;

Route::get('/calculator', function () {
    return view('calc_form');
})->name('calc.form');

Route::post('/calculator', function (Request $request) {
    try {
        $data = [
            'num1' => (int)$request->input('num1'),
            'num2' => (int)$request->input('num2'),
            'action' => $request->input('action')
        ];

        $pythonPath = 'C:\\Users\\HAIER\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
        $scriptPath = base_path('public\\python\\process_json1.py');

        $process = new Process([$pythonPath, $scriptPath, json_encode($data)], null, [
            'PYTHONHASHSEED' => '0'
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return redirect()->route('calc.form')->with('result', trim($process->getOutput()));
    } catch (\Exception $e) {
        return redirect()->route('calc.form')->with('result', 'Error: ' . $e->getMessage());
    }
})->name('calc.process');

//to here

//from here    capture image

//use Illuminate\Support\Facades\Route;
//use Symfony\Component\Process\Process;
//use Symfony\Component\Process\Exception\ProcessFailedException;

Route::get('/camera', function () {
    return view('capture_form');
})->name('camera.form');

Route::get('/capture-image', function () {
    try {
        $pythonPath = 'C:\\Users\\HAIER\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
        $scriptPath = base_path('public\\python\\capture_image.py');

        $process = new Process([$pythonPath, $scriptPath], base_path(), [
            'PYTHONHASHSEED' => '0',
            'PATH' => getenv('PATH'),
            'TEMP' => sys_get_temp_dir(),
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = json_decode($process->getOutput(), true);

        if ($output['status'] === 'success') {
            return redirect()->route('camera.form')->with('image', $output['image']);
        } else {
            return redirect()->route('camera.form')->with('image', null);
        }
    } catch (\Exception $e) {
        return redirect()->route('camera.form')->with('image', null);
    }
})->name('capture.image');



//from here
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\UsersAttendanceController;

// Route to display the form (GET)
Route::get('/attendance/register-face', [UsersAttendanceController::class, 'captureForm'])->name('attendance.capture-form');

// Route to handle the form submission (POST)
Route::post('/attendance/register-face', [UsersAttendanceController::class, 'registerFace'])->name('attendance.register-face');

// Route to train the face recognition model
Route::get('/attendance/train-face-model', [UsersAttendanceController::class, 'trainFaceRecognitionModel']);

Route::post('/recognize-face', [UsersAttendanceController::class, 'recognizeFace'])->name('recognize-face');
// routes/web.php
Route::get('/recognize-face-form', function () {
    return view('recognize_face');
});

//to here


Route::get('/run-random-forest', function () {
    try {
        $pythonExecutable = 'C:/Users/HAIER/AppData/Local/Programs/Python/myenv/Scripts/python.exe';
        //$scriptPath = 'C:/inetpub/wwwroot/larval-Crunchee/random_forest.py';
        $scriptPath = 'C:/inetpub/wwwroot/larval-Crunchee/random_forest_g.py';
        $csvPath = base_path('storage/app/public/td.csv');

        // Check if files exist
        if (!file_exists($pythonExecutable)) throw new \Exception("Python executable not found.");
        if (!file_exists($scriptPath)) throw new \Exception("Python script not found.");
        if (!file_exists($csvPath)) throw new \Exception("CSV file not found.");

        // Run the process with PYTHONHASHSEED=0
        $process = new Process([
            $pythonExecutable, 
            $scriptPath, 
            $csvPath
        ]);

        $process->setEnv([
            'PYTHONHASHSEED' => '0',
            'SYSTEMROOT' => getenv('SYSTEMROOT'),  // Ensure Windows system variables are available
            'Path' => getenv('Path'), // Ensure Python can find required DLLs
        ]);
        $process->setTimeout(300);
        $process->run();

        // Check for errors
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['output' => $process->getOutput()]);
        
    } catch (\Exception $e) {
        Log::error('Error executing Python script: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()]);
    }
});


Route::get('/run-linear-regression', function () {
    try {
        $pythonExecutable = 'C:/Users/HAIER/AppData/Local/Programs/Python/myenv/Scripts/python.exe';  // Adjust path if needed
        $scriptPath = 'C:/inetpub/wwwroot/larval-Crunchee/linear_regression.py';  // Path to the Linear Regression script
        $csvPath = base_path('storage/app/public/regdata.csv');  // Path to your CSV file (make sure it's accessible)

        // Check if the necessary files exist
        if (!file_exists($pythonExecutable)) throw new \Exception("Python executable not found.");
        if (!file_exists($scriptPath)) throw new \Exception("Python script not found.");
        if (!file_exists($csvPath)) throw new \Exception("CSV file not found.");

        // Run the Python script and pass the CSV file path as an argument
        $process = new Process([
            $pythonExecutable, 
            $scriptPath, 
            $csvPath
        ]);

        // Set environment variables for the process (for Windows compatibility)
        $process->setEnv([
            'PYTHONHASHSEED' => '0',
            'SYSTEMROOT' => getenv('SYSTEMROOT'),
            'Path' => getenv('Path'),
        ]);
        $process->setTimeout(300);  // Set timeout to ensure process doesn't hang forever
        $process->run();  // Run the script

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Return the output (prediction or model success message)
        $output = trim($process->getOutput());  // Using trim() to remove \r\n

        return response()->json(['output' => $output]);

    } catch (\Exception $e) {
        Log::error('Error executing Python script: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()]);
    }
});
