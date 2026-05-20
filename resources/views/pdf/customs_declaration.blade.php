<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customs Declaration</title>
</head>
<body>
    <h1>Customs Declaration (CN22/CN23)</h1>
    <p>Tracking No: {{ $exportRequest->tracking_no }}</p>
    <p>Sender: {{ $exportRequest->user->name }}</p>
    <p>Recipient: {{ $exportRequest->recipient_name }}, {{ $exportRequest->recipient_address }}</p>
    <p>Contents: {{ $exportRequest->goods_description }}</p>
    <p>Weight: {{ $exportRequest->weight_kg }} kg</p>
    <p>Value: {{ $exportRequest->currency }} {{ $exportRequest->declared_value }}</p>
</body>
</html>
