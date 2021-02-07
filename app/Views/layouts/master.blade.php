<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$pageTitle ?? "Soda - Framework"}}</title>

    <script src="/vendor/vue/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="/css/app.a2.css" rel="stylesheet">

    @yield('header')

</head>

<body>

    <div id="app" v-cloak>
        @yield('content')
    </div>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="/vendor/notify/notify.min.js"></script>
    <script src='https://cdn.rawgit.com/lcdsantos/menuspy/fa5bc803/dist/menuspy.min.js'></script>

    <script>
        $.notify.addStyle('notif', {
            html: "<div><span data-notify-text/></div>",
            classes: {
                base: {
                    "opacity": "0.90",
                    "white-space": "nowrap",
                    "color": "#ffffff",
                    "border-radius": "5px",
                    "padding": "7px"
                },
                error: {
                    "background-color": "#B94A48"
                }
            }
        });
    </script>

    @yield('script')

</body>

</html>
