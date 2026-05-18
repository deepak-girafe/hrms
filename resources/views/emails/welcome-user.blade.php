<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

</head>

<body style="font-family:Arial;">

    <h2>
        Welcome to HRMS
    </h2>

    <p>

        Hello {{ $user->name }},

    </p>

    <p>

        Your account has been created successfully.

    </p>

    <p>

        <strong>Email:</strong>
        {{ $user->email }}

    </p>

    <p>

        <strong>Password:</strong>
        {{ $password }}

    </p>

    <p>

        <strong>Login URL:</strong>

        <a href="{{ url('/login') }}">

            {{ url('/login') }}

        </a>

    </p>

    <br>

    <p>

        Regards,<br>
        HRMS Team

    </p>

</body>
</html>