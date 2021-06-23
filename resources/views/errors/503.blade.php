<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="origin" name="referrer">
    <title>Service Unavailable · Taskord</title>
    <meta name="viewport" content="width=device-width">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Fira Code", monospace;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ecf0f1;
        }

        .container {
            text-align: center;
            margin: auto;
            padding: 20px;
        }

        .container img {
            width: 100px;
            height: 100px;
        }

        .container h1 {
            margin-top: 30px;
            margin-bottom: 30px;
            font-size: 35px;
            text-align: center;
        }

        .container p {
            margin-top: 10px;
            color: #666666;
        }

        .container p.info {
            margin-top: 40px;
            font-size: 12px;
            color: #666666;
        }

        .container p.info a {
            text-decoration: none;
            color: #666666;
        }

    </style>
</head>

<body>
    <div class="container">
        <img loading=lazy src="https://ik.imagekit.io/taskordimg/pride_vocaCTHn-.svg" />
        <h1>Taskord is down!</h1>
        <p>We're doing our best to get Taskord back to normal.</p>
        <p class="info">
            <a href="{{ route('contact') }}">Taskord Support</a> —
            <a href="https://status.taskord.com">Taskord Status</a> —
            <a href="https://twitter.com/taskord">@taskord</a>
        </p>
    </div>
</body>

</html>
