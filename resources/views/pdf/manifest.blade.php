<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manifest</title>
</head>
<body>
    <h1>Dispatch Manifest</h1>
    <p>Tracking No: {{ $exportRequest->tracking_no }}</p>
    <p>Service: {{ $exportRequest->service_type }}</p>
    <p>Destination: {{ $exportRequest->destination_city }}, {{ $exportRequest->destination_country }}</p>
    <p>Dispatch Date: {{ now()->format('Y-m-d H:i') }}</p>
</body>
</html>
