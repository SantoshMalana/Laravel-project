<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>
<body>
    <h1>Commercial Invoice</h1>
    <p>Tracking No: {{ $exportRequest->tracking_no }}</p>
    <p>Customer: {{ $exportRequest->user->name }}</p>
    <p>Destination: {{ $exportRequest->destination_country }}</p>
    <p>Declared Value: {{ $exportRequest->currency }} {{ $exportRequest->declared_value }}</p>
</body>
</html>
