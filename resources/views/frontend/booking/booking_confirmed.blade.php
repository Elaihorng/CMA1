<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
</head>
<body>
    <h1>Hello {{ $booking->name }},</h1>
    <p>Your booking for <strong>{{ $booking->service_date }}</strong> has been successfully confirmed.</p>
    <p>Thank you for choosing us!</p>
</body>
</html>
