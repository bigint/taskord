<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Security-Policy" content="default-src 'none'; base-uri 'self'; connect-src 'self'; form-action 'self'; img-src 'self' data:; script-src 'self'; style-src 'unsafe-inline'">
        <meta content="origin" name="referrer">
        <title>Rate limit · Taskord</title>
        <meta name="viewport" content="width=device-width">
        <style type="text/css" media="screen">
            body {
                background-color: #f6f8fa;
                color: #24292e;
                font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                font-size: 14px;
                line-height: 1.5;
                margin: 0;
            }
            .container { margin: 50px auto; max-width: 600px; text-align: center; padding: 0 24px; }
            a { color: #0366d6; text-decoration: none; }
            a:hover { text-decoration: underline; }
            h1 { line-height: 60px; font-size: 48px; font-weight: 300; margin: 0px; text-shadow: 0 1px 0 #fff; }
            p { color: rgba(0, 0, 0, 0.5); margin: 20px 0 40px; }
            ul { list-style: none; margin: 25px 0; padding: 0; }
            li { display: table-cell; font-weight: bold; width: 1%; }
            .logo { display: inline-block; margin-top: 35px; }
            #suggestions {
                margin-top: 35px;
                color: #ccc;
            }
            #suggestions a {
                color: #666666;
                font-weight: 200;
                font-size: 14px;
                margin: 0 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Whoa there!</h1>
            <p>
                You have triggered an abuse detection mechanism.
                <br>
                <br>
                Please wait a few minutes before you try again.
                <br>
                Make sure that you are not abusing our system!
                <br>
            </p>
            <div id="suggestions">
                <a href="https://taskord.com/contact">Taskord Support</a> —
                <a href="https://status.taskord.com">Taskord Status</a> —
                <a href="https://twitter.com/taskord">@taskord</a>
            </div>
            <a href="/" class="logo">
            <img width="32" height="32" title="" alt="" src="/images/error.svg">
            </a>
        </div>
    </body>
</html>
