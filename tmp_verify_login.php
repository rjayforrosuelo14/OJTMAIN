<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Intern;
use App\Models\Supervisor;

$email = 'Rjayforsuelo@gmail.com';
$password = 'James@2025*';

function checkModel($model, $email, $password) {
    $record = $model::where('email', $email)->first();
    $modelName = is_string($model) ? $model : get_class($model);
    if (!$record) {
        echo $modelName . ": not found\n";
        return;
    }
    echo $modelName . ": found id=" . $record->id . " name=" . ($record->name ?? ($record->first_name . ' ' . $record->last_name) ?? 'N/A') . "\n";
    if (isset($record->password) && Hash::check($password, $record->password)) {
        echo "  password match\n";
    } else {
        echo "  password mismatch\n";
    }
}

checkModel(User::class, $email, $password);
checkModel(Intern::class, $email, $password);
checkModel(Supervisor::class, $email, $password);
