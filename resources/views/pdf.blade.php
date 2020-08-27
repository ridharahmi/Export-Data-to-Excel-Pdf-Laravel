<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>List Users</title>
    <style>
        h2 span {
            color: red;
        }
    </style>
</head>

<body>
<h1> List Users</h1>
<h2><span>{{ $count }}</span> Users</h2>
<table class="table" border="1">
    <thead>
    <tr>
        <th scope="col">#Id</th>
        <th scope="col">Name</th>
        <th scope="col">email</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
    @empty
        <p>No users</p>
    @endforelse
    </tbody>
</table>
</body>
</html>