<!DOCTYPE html>
<html>
<head>
    <title>Customer Login Notification</title>
</head>
<body>
    <h2>Customer Login Alert</h2>
    <p>The following customer has logged in:</p>
    <ul>
        <li>Name: {{ $customer->name }}</li>
        <li>Email: {{ $customer->email }}</li>
        <li>Login Time: {{ now() }}</li>
    </ul>
</body>
</html>
