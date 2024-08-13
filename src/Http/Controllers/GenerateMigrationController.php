<?php

namespace Developerawam\GenerateMigration\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Developerawam\GenerateMigration\GenerateMigration;
use Developerawam\GenerateMigration\Http\Requests\StoreGenerateMigrationRequest;

class GenerateMigrationController extends Controller
{
    public function store(StoreGenerateMigrationRequest $request){

        $table_name = $request->table_name;
        $table_columns = [];

        foreach ($request->name as $key => $value) {
            // push to table_columns array
            array_push($table_columns, [
                'name' => $value,
                'type' => $request->type[$key],
                'values' => $request->values[$key] ? explode(',', $request->values[$key]) : null,
                'default' => $request->default[$key],
            ]);
        }

        GenerateMigration::create($table_name, $table_columns);

        return response()->json([
            'success' => true,
            'message' => 'Migration created successfully'
        ]);
    }
}
