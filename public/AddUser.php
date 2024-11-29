<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-center">Tambah User Baru</h1>
        <form action="/users/add" method="post" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username:</label>
                <input type="text" id="username" name="username" required class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama:</label>
                <input type="text" id="name" name="name" required class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" required class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone:</label>
                <input type="text" id="phone" name="phone" required class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="password" id="password" name="password" required class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="url" class="block text-gray-700">Url:</label>
                <input type="text" id="url" name="url" class="border p-2 w-full">
            </div>
            <div class="text-center">
                <input type="submit" value="Tambah User" class="bg-blue-500 text-white px-4 py-2 rounded">
            </div>
        </form>
    </div>
</body>
</html>
