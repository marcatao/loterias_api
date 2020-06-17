<html>
<head>

</head>
<body>
    <center>
     <h2>Purchase successful !</h2>
    <p>Debit Brazilian Reais: - R$ {{ $data->btc_price * $data->value}}</p>
    <p>Btc price: BTC {{ $data->btc_price }}</p>
    <p>Credit bitcoin buys: BTC {{ $data->value }}</p>
    </center>
</body>
</html>