<!DOCTYPE html>
<html>
<head>
	<title>My essential app</title>
	<link rel="stylesheet" href="/css/all.css" />
</head>
<body>
    <div class="container">

    	@include('flash::message')

        @yield('content')
    </div>

    <script>
    	$('#flash-overlay-modal').modal();
    </script>

	<script src="/js/all.js"></script>		


    @yield('footer')
</body>
</html>