<?php

namespace Developerawam\GenerateMigration;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class GenerateMigration
{
    public static function create(string $table, array $payload){

        self::checkTableExists($table);

        // use try catch to handle exception and if catch rollback migration
        try {

            $table_name = lcfirst(str_replace(' ', '', ucwords($table)));

            // call artisan migrate
            Artisan::call('migrate');

            // call artisan make model and migration
            Artisan::call('make:model', [
                'name' => $table_name,
                '--migration' => true
            ]);

            // get payload for add to migration
            $migrationFile = collect(File::files(database_path('migrations')))
                            ->sortByDesc(function ($file) {
                                return $file->getCTime();
                            })
                            ->first()
                            ->getFileName();

            // add columns to migration
            self::addColumnsToMigration(database_path('migrations') . '/' . $migrationFile, $payload);

            // call artisan migrate
            Artisan::call('migrate');

            // return success message
            return response()->json([
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            // rollback migration
            Artisan::call('migrate:rollback');
            throw new Exception($e);
        }

    }

    private static function addColumnsToMigration($filePath, $columns) {
        // read content file migrasi
        $migrationContent = File::get($filePath);

        // find position to add column after `$table->id();`
        $idPos = strpos($migrationContent, '$table->id();');
        $timestampsPos = strpos($migrationContent, '$table->timestamps();');

        // prepare string for add column
        $columnsString = '';
        foreach ($columns as $column) {
            $columnType = $column['type'];
            $columnName = strtolower(str_replace(' ', '_', $column['name']));
            $default = isset($column['default']) ? "->default('{$column['default']}')" : '';

            switch ($columnType) {
                case 'string':
                    $columnsString .= "\$table->string('$columnName')$default;\n";
                    break;
                case 'text':
                    $columnsString .= "\$table->text('$columnName')$default;\n";
                    break;
                case 'integer':
                    $columnsString .= "\$table->integer('$columnName')$default;\n";
                    break;
                case 'bigInteger':
                    $columnsString .= "\$table->bigInteger('$columnName')$default;\n";
                    break;
                case 'decimal':
                    $precision = isset($column['precision']) ? $column['precision'] : 8;
                    $scale = isset($column['scale']) ? $column['scale'] : 2;
                    $columnsString .= "\$table->decimal('$columnName', $precision, $scale)$default;\n";
                    break;
                case 'float':
                    $precision = isset($column['precision']) ? $column['precision'] : 8;
                    $scale = isset($column['scale']) ? $column['scale'] : 2;
                    $columnsString .= "\$table->float('$columnName', $precision, $scale)$default;\n";
                    break;
                case 'date':
                    $columnsString .= "\$table->date('$columnName')$default;\n";
                    break;
                case 'time':
                    $columnsString .= "\$table->time('$columnName')$default;\n";
                    break;
                case 'timestamp':
                    $default = ($default === 'CURRENT_TIMESTAMP') ? "->useCurrent()" : $default;
                    $columnsString .= "\$table->timestamp('$columnName')$default;\n";
                    break;
                case 'boolean':
                    $default = ($default === 'true') ? "->default(true)" : "->default(false)";
                    $columnsString .= "\$table->boolean('$columnName')$default;\n";
                    break;
                case 'enum':
                    $values = implode("', '", $column['values']);
                    $columnsString .= "\$table->enum('$columnName', ['$values'])$default;\n";
                    break;
                case 'json':
                    $columnsString .= "\$table->json('$columnName')$default;\n";
                    break;
            }
        }

        // insert column after `$table->id();` and before `$table->timestamps();`
        $beforeTimestamps = substr($migrationContent, 0, $timestampsPos);
        $afterTimestamps = substr($migrationContent, $timestampsPos);
        $migrationContent = $beforeTimestamps . $columnsString . $afterTimestamps;

        // write back to migration file
        File::put($filePath, $migrationContent);
    }

    private static function checkTableExists($table) {
        if (Schema::hasTable(self::convertTableName($table))) {
            throw new Exception("tabel {$table} already exists");
        }
    }

    private static function convertTableName($tableName) {
        // Check if the table name ends with 'y'
        if (substr($tableName, -1) === 'y') {
            // Replace 'y' with 'ies'
            $tableName = substr($tableName, 0, -1) . 'ies';
        } else {
            // Optionally, handle other cases if needed
            // For example, add a default pluralization rule
            $tableName .= 's';
        }

        return $tableName;
    }
}
