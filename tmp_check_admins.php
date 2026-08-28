<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$admins = User::all();
if ($admins->isEmpty()) {
    echo "No admin users found.\n";
    exit(0);
}

foreach ($admins as $admin) {
    echo sprintf("%d | %s | %s | created_at=%s\n",
        $admin->id,
        $admin->name,
        $admin->email,
        $admin->created_at
    );
}
