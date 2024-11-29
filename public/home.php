<?php

require __DIR__ . '/../vendor/autoload.php'; // Pastikan autoload di-include

use App\Models\User;

$users = User::all();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-center">Daftar Semua User</h1>
        <div class="flex justify-center mb-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="window.location.href='/users/add'">Tambah User</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo $user['id_user']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $user['name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $user['email']; ?></td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="openDetailModal(<?php echo $user['id_user']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', '<?php echo $user['url']; ?>')">Detail</button>
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="openUpdateModal(<?php echo $user['id_user']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', '<?php echo $user['url']; ?>')">Update</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="openDeleteModal(<?php echo $user['id_user']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white p-6 rounded shadow-lg w-11/12 md:w-1/2">
            <h2 class="text-xl font-bold mb-4">Detail User</h2>
            <p><strong>Username:</strong> <span id="detail_username"></span></p>
            <p><strong>Nama:</strong> <span id="detail_name"></span></p>
            <p><strong>Email:</strong> <span id="detail_email"></span></p>
            <p><strong>Phone:</strong> <span id="detail_phone"></span></p>
            <p><strong>Url:</strong> <a id="detail_url" href="#" target="_blank"><span id="detail_url_text"></span></a></p>
            <button type="button" onclick="closeDetailModal()" class="bg-gray-500 text-white px-4 py-2 rounded mt-4">Tutup</button>
        </div>
    </div>

    <!-- Modal Update -->
    <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white p-6 rounded shadow-lg w-11/12 md:w-1/2">
            <form id="updateForm" action="" method="post">
                <input type="hidden" id="update_id_user" name="id_user">
                <label for="update_username" class="block">Username:</label>
                <input type="text" id="update_username" name="username" class="border p-2 w-full mb-4" required>

                <label for="update_name" class="block">Nama:</label>
                <input type="text" id="update_name" name="name" class="border p-2 w-full mb-4" required>
                
                <label for="update_email" class="block">Email:</label>
                <input type="email" id="update_email" name="email" class="border p-2 w-full mb-4" required>
                
                <label for="update_phone" class="block">Phone:</label>
                <input type="text" id="update_phone" name="phone" class="border p-2 w-full mb-4" required>

                <label for="update_url" class="block">Url:</label>
                <input type="text" id="update_url" name="url" class="border p-2 w-full mb-4">

                <input type="submit" value="Update User" class="bg-green-500 text-white px-4 py-2 rounded">
                <button type="button" onclick="closeUpdateModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            </form>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white p-6 rounded shadow-lg w-11/12 md:w-1/3">
            <p>Apakah Anda yakin ingin menghapus user ini?</p>
            <form id="deleteForm" action="" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                <input type="hidden" id="delete_id_user" name="id_user">
                <input type="submit" value="Hapus User" class="bg-red-500 text-white px-4 py-2 rounded">
                <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            </form>
        </div>
    </div>

    <script>
    function openDetailModal(id, username, name, email, phone, url) {
        document.getElementById('detail_username').innerText = username;
        document.getElementById('detail_name').innerText = name;
        document.getElementById('detail_email').innerText = email;
        document.getElementById('detail_phone').innerText = phone;
        document.getElementById('detail_url').href = url;
        document.getElementById('detail_url_text').innerText = url;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function openUpdateModal(id, username, name, email, phone, url) {
        document.getElementById('updateForm').action = `/users/update/${id}`;
        document.getElementById('update_id_user').value = id;
        document.getElementById('update_username').value = username;
        document.getElementById('update_name').value = name;
        document.getElementById('update_email').value = email;
        document.getElementById('update_phone').value = phone;
        document.getElementById('update_url').value = url;
        document.getElementById('updateModal').style.display = 'flex';
    }

    function openDeleteModal(id) {
        document.getElementById('deleteForm').action = '/users/delete/' + id;
        document.getElementById('delete_id_user').value = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function closeUpdateModal() {
        document.getElementById('updateModal').style.display = 'none';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
    </script>
</body>
</html>
