@extends('generate-ui::layouts.main')

@section('content')
    <!-- Content -->
    <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">

        <div id="toast-error" class="space-y-3 mb-4 hidden">
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-error-example-label">
                <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="toast-error-message" class="text-sm text-gray-700 dark:text-neutral-400"></p>
                </div>
                </div>
            </div>
        </div>

        <div id="toast-success" class="space-y-3 mb-4 hidden">
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label">
                <div class="flex p-4">
                    <div class="shrink-0">
                    <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                    </svg>
                    </div>
                    <div class="ms-3">
                    <p id="toast-success-message" class="text-sm text-gray-700 dark:text-neutral-400"></p>
                    </div>
                </div>
            </div>
        </div>

        <form id="generateForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="input-label" class="block text-sm font-medium mb-2 dark:text-white">Table Name</label>
                <input type="text" name="table_name" id="input-label" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="posts" required>
            </div>
            <button type="button" id="addColumn" class="mb-3 py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                add column
            </button>
            <hr>
            <div id="tableColumn" class="mb-5">
                <div class="grid grid-cols-4 gap-4 mt-3">
                    <div>
                        <label for="column_name" class="block text-sm font-medium leading-6 text-gray-900">Column name</label>
                        <div class="mt-2">
                            <input type="text" name="name[]" id="column_name" autocomplete="column-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="column_name" required>
                        </div>
                    </div>
                    <div class="select-default">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                        <div class="mt-2">
                        <select name="type[]" autocomplete="type" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 select-type">
                            <option value="string">String</option>
                            <option value="text">Text</option>
                            <option value="integer">Integer</option>
                            <option value="decimal">Decimal</option>
                            <option value="float">Float</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="timestamp">Timestamp</option>
                            <option value="boolean">Boolean</option>
                            <option value="enum">Enum</option>
                            <option value="json">Json</option>
                        </select>
                        </div>
                    </div>
                    <div class="row-enums hidden">
                        <label for="values" class="block text-sm font-medium leading-6 text-gray-900">Values</label>
                        <div class="mt-2">
                            <input type="text" name="values[]" id="values" autocomplete="values" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder='pending, success, failed'>
                        </div>
                    </div>
                    <div class="default">
                        <label for="default" class="block text-sm font-medium leading-6 text-gray-900">Default Value</label>
                        <div class="mt-2">
                            <input type="text" name="default[]" id="default" autocomplete="default" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 default-value" placeholder="default value">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none mt-5">
                Create
            </button>
        </form>
    </div>
    <!-- End Content -->
@endsection
