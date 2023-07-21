<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー一覧</title>
</head>
<body>
    <h1>ユーザー一覧</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Login ID</th>
            <th>Password</th>
            <th>Admin Flag</th>
            <th>Life Flag</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user->id); ?></td>
            <td><?php echo htmlspecialchars($user->name); ?></td>
            <td><?php echo htmlspecialchars($user->loginId); ?></td>
            <td><?php echo htmlspecialchars($user->password); ?></td>
            <td><?php echo htmlspecialchars($user->adminFlag); ?></td>
            <td><?php echo htmlspecialchars($user->lifeFlag); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>