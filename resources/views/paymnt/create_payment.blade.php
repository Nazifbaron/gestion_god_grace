<!DOCTYPE html>
<html>
<head>
    <title>Paiement</title>
</head>
<body>
    <form action="{{ route('payment.create') }}" method="POST">
        @csrf
        <label for="amount">Montant :</label>
        <input type="number" name="amount" id="amount" required>
        <label for="description">Description :</label>
        <input type="text" name="description" id="description" required>
        <button type="submit">Payer avec FedaPay</button>
    </form>
</body>
</html>
