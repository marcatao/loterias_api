<html>
<head>

</head>
<body>
    <center>
     <h2>Successful sale !</h2>
    <p>Credit Brazilian Reais: R$ {{ $data->value }}</p>
    <p>Btc price: BTC {{ $data->btc_price }}</p>
    <p>Debit biticoin sell: -{{ $data->value/$data->btc_price}}</p>
    </center>
</body>
</html>