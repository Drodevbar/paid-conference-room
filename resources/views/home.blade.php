<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paid Conference Room</title>
</head>
<body>

<form action="{{ route('payment') }}" method="post" id="paypal_form">
    @csrf
    <input name="email" placeholder="Email address" />
    <input name="nickname" placeholder="Nickname" />
    <input name="submit" type="submit" value="Submit"/>
</form>

@if(session('error'))
    <small>{{ session('error') }}</small>
@endif

</body>
</html>