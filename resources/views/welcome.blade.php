<!DOCTYPE html>
<html>
<head>
    <title>{{ __(key: 'messages.app_name') }}</title>

    <style>
        body {
            margin: 0;
        }

        div {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
        }

        h1 {
            color: black;
        }


        @media (prefers-color-scheme: dark) {
            div {
                background-color: black;
            }

            h1 {
                color: white;
            }
        }


        @media (prefers-color-scheme: light) {
            div {
                background-color: white;
            }

            h1 {
                color: black;
            }
        }
    </style>
</head>

<body>
<div>
    <h1>{{ __(key: 'messages.app_name') }}</h1>
</div>
</body>
</html>
