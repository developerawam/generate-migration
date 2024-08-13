<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate Migration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/generate-migration/app.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>
    <body>

        @include('generate-ui::components.sidebar')

        <!-- ========== CONTENT ========== -->
        @yield('content')
        <!-- ========== END MAIN CONTENT ========== -->

        <script>
            const tableColumn = document.getElementById('tableColumn');
            const addColumn = document.getElementById('addColumn');
            const removeColumn = document.querySelector('.removeColumn');
            const submitForm = document.getElementById('generateForm');

            var rowDefaultHtml = `
                <div class="grid grid-cols-4 gap-4 mt-3 row-new-column">
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
                    <div class="default gap-1 grid grid-cols-3">
                        <div class="col-span-2">
                            <label for="default" class="block text-sm font-medium leading-6 text-gray-900">Default Value</label>
                            <div class="mt-2">
                                <input type="text" name="default[]" id="default" autocomplete="default" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 default-value" placeholder="default value">
                            </div>
                        </div>
                        <div class="flex items-end justify-end">
                            <button type="button" class="removeColumn py-2 px-2 inline-flex items-center text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" id="IconChangeColor" height="20" width="20"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" id="mainIconPathAttribute" fill="#ffffff"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            addColumn.addEventListener('click', () => {
                // Add row default HTML to table column
                tableColumn.insertAdjacentHTML('beforeend', rowDefaultHtml);
                addRemoveListeners();
            });

            document.querySelectorAll('.select-type').forEach(select => {
                select.addEventListener('change', handleSelectChange);
            });

            function addRemoveListeners() {
                const removeButtons = document.querySelectorAll('.removeColumn');
                removeButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const parentRow = event.target.closest('.row-new-column');
                        if (parentRow) {
                            parentRow.remove();
                        }
                    });
                });

                document.querySelectorAll('.select-type').forEach(select => {
                    select.addEventListener('change', handleSelectChange);
                });
            }

            // Function to handle the select change event
            function handleSelectChange(event) {
                const selectedValue = event.target.value;
                const container = event.target.parentElement.parentElement;
                const rowEnums = container.parentElement.querySelector('.row-enums')
                if (selectedValue === 'enum') {
                    rowEnums.classList.remove('hidden')
                } else {
                    rowEnums.classList.add('hidden')
                }
            }

            // submitForm
            submitForm.addEventListener('submit', (event) => {
                event.preventDefault();

                const formData = new FormData(event.target);

                // Convert FormData to JSON
                const data = {};
                formData.forEach((value, key) => {
                    if (key.endsWith('[]')) {
                        key = key.slice(0, -2); // Remove the trailing []
                        if (!data[key]) {
                            data[key] = [];
                        }
                        data[key].push(value);
                    } else {
                        data[key] = value;
                    }
                });

                // store data with fetch
                fetch('{{ route('generate-migration.submit') }}', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const toastError = document.getElementById('toast-error');
                    const toastSuccess = document.getElementById('toast-success');
                    const toastErrorMessage = document.getElementById('toast-error-message');
                    const toastSuccessMessage = document.getElementById('toast-success-message');

                    if (data.errors) {
                        toastError.classList.remove('hidden');
                        toastErrorMessage.textContent = data.message;
                    } else {
                        // location reload wit set timeout 3 second
                        toastSuccess.classList.remove('hidden');
                        toastSuccessMessage.textContent = data.message;
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            })

        </script>

    </body>
</html>
