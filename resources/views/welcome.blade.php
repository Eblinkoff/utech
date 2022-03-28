<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .window {
                width: 50%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
			<div class="list window">
				@include('list')
			</div>
			<div class="modal window">
				@include('modal')
			</div>
        </div>
    </body>
</html>
