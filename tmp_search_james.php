<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Intern;
use App\Models\Supervisor;

function searchTable($model, $fields, $term) {
    $results = $model::where(function ($q) use ($fields, $term) {
        foreach ($fields as $field) {
            $q->orWhere($field, 'LIKE', "%{$term}%");
        }
    })->get();

    $modelName = is_string($model) ? $model : get_class($model);
    echo $modelName . " results:\n";
    if ($results->isEmpty()) {
        echo "  none\n";
        return;
    }
    foreach ($results as $record) {
        $values = [];
        foreach ($fields as $field) {
            $values[] = "$field=" . ($record->$field ?? '');
        }
        echo '  id=' . $record->id . ' | ' . implode(' | ', $values) . "\n";
    }
}

$term = 'james';
searchTable(User::class, ['name', 'email'], $term);
searchTable(Intern::class, ['first_name', 'last_name', 'email'], $term);
searchTable(Supervisor::class, ['name', 'email'], $term);
