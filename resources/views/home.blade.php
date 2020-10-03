<html>
    <head>
        <title>@yield('title') - Laravel</title>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        
		<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    </head>

    <body>
        <header style="position:absolute; top:10px; right: 10px;">
            <a class="mr-3" href="#">About</a>
            <a class="mr-3" href="#">Playing</a>
            <a class="mr-3" href="#">Login</a>
        </header>

        <section>
            <h1>Cloud Stage</h1>
            <p>Cloud Stage Live Show - Launching Soon!<br />
            Be the first to know!</p>
        </section>

        <form id="signup-form" method="post" action="#">
            <input type="email" name="email" id="email" placeholder="Email Address" />
            <input type="submit" value="Sign Up" />
        </form>

        <footer id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
                <li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>&copy; Untitled.</li><li>Credits: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>
        </footer>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>