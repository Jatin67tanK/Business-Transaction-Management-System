<?php
include '../db.php';

$search = $_POST['search'] ?? '';
$table = $_POST['table'] ?? '';
$uname = $_POST['uname'] ?? '';
$role = $_POST['role'] ?? '';

if ($table == 'users' ) {
        if($search == ''){
                $sql = "select * from {$table}";
        }
        else{
    $sql = "SELECT * FROM {$table} 
        WHERE username LIKE '%$search%' 
        OR email LIKE '%$search%' 
        OR role LIKE '%$search%' 
        OR id LIKE '%$search%'";
        }
        $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<form class='category-item table-head'>
            <input type='text' value='ID' readonly>
            <input type='text' value='Username' readonly>
            <input type='text' value='Email' readonly>
            <input type='text' value='Role' readonly>
            <input type='text' value='Action' readonly>
          </form>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<form method='POST' class='category-item' onsubmit='return confirm(\"Are you sure?\");'>
                <input type='text' name='id' value='{$row['id']}' readonly>
                <input type='text' name='username' value='{$row['username']}' readonly>
                <input type='text' name='email' value='{$row['email']}' readonly>
                <input type='text' name='role' value='{$row['role']}' readonly>";
        if ($row['role'] != 'admin') {
            echo "<button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>";
        }
        echo "</form>";
    }
} else {
    echo "<p>No matching users found.</p>";
}
}
else if($table == 'categories' ) {
        if($search == ''){
                $sql = "select * from {$table}";
        }
        else{
    $sql = "SELECT * FROM {$table} 
        WHERE name LIKE '%$search%' 
        OR id LIKE '%$search%'";
        }

        $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
//     echo "<form class='category-item table-head'>
//             <input type='text' value='ID' readonly>
//             <input type='text' value='Username' readonly>
//             <input type='text' value='Email' readonly>
//             <input type='text' value='Role' readonly>
//             <input type='text' value='Action' readonly>
//           </form>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<form method='POST' class='category-item' onsubmit='return confirm(\"Are you sure?\");'>
                <input type='text' name='id' value='{$row['id']}' readonly>
                <input type='text' name='name' value='{$row['name']}' readonly>
                <a href='/project/admin/edit_category.php?id={$row['id']}; ' class='btn btn-primary'>Edit</a>
                <button type='submit' name='delete' class='btn delete'>Delete</button>";
        echo "</form>";
    }
} else {
    echo "<p>No matching Categories found.</p>";
}
                
}else {

    if ($search == '') {
        $sql = "SELECT * FROM {$table}";
    } else {
        $sql = "SELECT * FROM {$table} 
                WHERE id LIKE '%$search%' 
                OR date LIKE '%$search%' 
                OR amount LIKE '%$search%' 
                OR mode LIKE '%$search%' 
                OR description LIKE '%$search%' 
                OR created_at LIKE '%$search%' 
                OR uname LIKE '%$search%' 
                OR category_id LIKE '%$search%'";
    }

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['category_id']}</td>
                    <td>{$row['mode']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['uname']}</td>";

            // ✅ Show Update/Delete buttons ONLY for Admin or Owner
            if ($role == 'admin' || $row['uname'] == $uname) {

                echo "<td class=\"btn-col\">
                        <form method='POST' style='display:inline;' 
                              onsubmit=\"return confirm('Are you sure you want to delete this record?');\">

                            <!-- Update Button -->
                            <button class='btn' 
                                    type='button' 
                                    onclick=\"window.location.href='/project/edit_Transaction.php?id={$row['id']}'\">
                                Update
                            </button>

                            <!-- Delete Button -->
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete' class='btn' 
                                    style='background-color:red;color:white;'>
                                Delete
                            </button>
                        </form>
                      </td>";
            }

            echo "</tr>";
        }
    } 
    else {
        echo "<tr><td colspan='10'>No matching transactions found.</td></tr>";
    }
}
