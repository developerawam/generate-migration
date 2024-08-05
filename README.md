# Laravel Auto Generate Model, Migration, and Table

[![Latest Version on Packagist](https://img.shields.io/packagist/v/developerawam/generate-migration.svg?style=flat-square)](https://packagist.org/packages/developerawam/generate-migration)
[![Total Downloads](https://img.shields.io/packagist/dt/developerawam/generate-migration.svg?style=flat-square)](https://packagist.org/packages/developerawam/generate-migration)

This package automatically generates migration files for your Laravel application. With this feature, you can quickly create database structures without writing SQL code manually. Simply specify the model you want to create, and this package will handle the rest, streamlining development and minimizing human errors.

## Requirements

- Laravel 11
- PHP 8.0

## Installation

You can install the package via composer:

```bash
composer require developerawam/generate-migration
```

## Usage

Use the `GenerateMigration` class to create a migration with the desired table name and columns. The example code below demonstrates how to create a migration for a `post` table with columns:

```php

    use Developerawam\GenerateMigration\GenerateMigration;

    // table name example
    $table_name = "post";

    // table column example
    $table_colom = [
        {
            "name": "name",
            "type": "string",
            "default": "default_name"
        },
        {
            "name": "description",
            "type": "text",
            "default": "default_description"
        },
        {
            "name": "age",
            "type": "integer",
            "default": 25
        },
        {
            "name": "views",
            "type": "bigInteger",
            "default": 0
        },
        {
            "name": "price",
            "type": "decimal",
            "precision": 8,
            "scale": 2,
            "default": 0.00
        },
        {
            "name": "rating",
            "type": "float",
            "precision": 8,
            "scale": 2,
            "default": 0.00
        },
        {
            "name": "birthdate",
            "type": "date",
            "default": "2000-01-01"
        },
        {
            "name": "appointment_time",
            "type": "time",
            "default": "12:00:00"
        },
        {
            "name": "created_at",
            "type": "timestamp",
            "default": "CURRENT_TIMESTAMP"
        },
        {
            "name": "is_active",
            "type": "boolean",
            "default": true
        },
        {
            "name": "status",
            "type": "enum",
            "values": ["pending", "approved", "rejected"],
            "default": "pending"
        },
        {
            "name": "settings",
            "type": "json",
            "default": "{\"theme\": \"dark\", \"notifications\": true}"
        }
    ];

    // table_name must be string
    // table_column must be array object
    GenerateMigration::create($table_name, $table_colom);

```

### Code Explanation

- $table_name: The name of the table you want to create, in this case, post.
- $table_columns: An array of columns to be created in the table. Each column is an array containing the column name (name) and data type (type).
- GenerateMigration::create($table_name, $table_columns): Calls the create method from the GenerateMigration class to create a migration based on the specified table name and columns.

### Testing

```bash
composer test
```

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

## Support the Project

If you find this project useful and would like to support its development, you can make a donation:

- [Buy Me a Coffee](https://trakteer.id/developer_awam/link)

