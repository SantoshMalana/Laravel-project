<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Packing List</title>
</head>
<body>
    <h1>Packing List</h1>
    <p>Tracking No: {{ $exportRequest->tracking_no }}</p>
    <p>Description: {{ $exportRequest->goods_description }}</p>
    <p>Total Weight: {{ $exportRequest->weight_kg }} kg</p>
</body>
</html>
