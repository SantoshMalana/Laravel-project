<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Origin</title>
</head>
<body>
    <h1>Certificate of Origin</h1>
    <p>Tracking No: {{ $exportRequest->tracking_no }}</p>
    <p>Country of Origin: {{ $exportRequest->origin }}</p>
    <p>Goods: {{ $exportRequest->goods_category }}</p>
</body>
</html>
