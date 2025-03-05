<style>
    .invoice-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .company-info {
        margin-bottom: 20px;
    }
    .customer-info {
        margin-bottom: 20px;
    }
    .invoice-details {
        margin-bottom: 20px;
    }
    .products-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .products-table th {
        background-color: #f8f8f8;
        border-bottom: 2px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .products-table td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }
    .totals-table {
        width: 100%;
        border-collapse: collapse;
    }
    .totals-table td {
        padding: 8px;
    }
    .text-right {
        text-align: right;
    }
    .font-bold {
        font-weight: bold;
    }
</style>

<div class="invoice-title">
    FACTURA #<?= $data['order']->order_id ?>
</div>

<div class="company-info">
    <strong>TIENDA MVC</strong><br>
    Calle Ejemplo, 123<br>
    28000 Madrid<br>
    España<br>
    CIF: B12345678<br>
    Email: info@tiendamvc.com
</div>

<div class="customer-info">
    <strong>CLIENTE:</strong><br>
    <?= $data['order']->customer->name ?><br>
    <?php if(isset($data['order']->customer->address)): ?>
    <?= $data['order']->customer->address->street ?><br>
    <?= $data['order']->customer->address->zip_code ?> <?= $data['order']->customer->address->city ?><br>
    <?= $data['order']->customer->address->country ?>
    <?php endif; ?>
</div>

<div class="invoice-details">
    <strong>DETALLES DE LA FACTURA:</strong><br>
    <table>
        <tr>
            <td width="120">Número:</td>
            <td>FAC-<?= date('Ym', strtotime($data['order']->date)) ?>-<?= $data['order']->order_id ?></td>
        </tr>
        <tr>
            <td>Fecha:</td>
            <td><?= date('d/m/Y', strtotime($data['order']->date)) ?></td>
        </tr>
    </table>
</div>

<table class="products-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio/ud</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subtotal = 0;
        foreach ($data['order']->products as $product): 
            $quantity = $product->pivot->quantity ?? 1;
            $price = $product->pivot->price ?? $product->price;
            $productSubtotal = $quantity * $price;
            $subtotal += $productSubtotal;
        ?>
        <tr>
            <td><?= $product->product_id ?></td>
            <td><?= $product->name ?></td>
            <td><?= number_format($price, 2) ?>€</td>
            <td><?= $quantity ?></td>
            <td><?= number_format($productSubtotal, 2) ?>€</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table class="totals-table">
    <tr>
        <td colspan="4" class="text-right font-bold">Subtotal:</td>
        <td width="100" class="text-right"><?= number_format($subtotal, 2) ?>€</td>
    </tr>
    <?php if($data['order']->discount > 0): 
        $discountAmount = $subtotal * ($data['order']->discount / 100);
    ?>
    <tr>
        <td colspan="4" class="text-right font-bold">Descuento (<?= $data['order']->discount ?>%):</td>
        <td class="text-right"><?= number_format($discountAmount, 2) ?>€</td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="4" class="text-right font-bold">TOTAL:</td>
        <td class="text-right font-bold"><?= number_format($subtotal - ($data['order']->discount > 0 ? $discountAmount : 0), 2) ?>€</td>
    </tr>
</table>

<div style="margin-top: 40px">
    <strong>INSTRUCCIONES DE PAGO:</strong><br>
    Transferencia bancaria a:<br>
    Banco: Banco Ejemplo<br>
    IBAN: ES00 0000 0000 0000 0000 0000<br>
    BIC/SWIFT: EXAMPLEBANK<br>
    Concepto: FAC-<?= date('Ym', strtotime($data['order']->date)) ?>-<?= $data['order']->order_id ?>
</div>

<div style="margin-top: 40px; font-size: 10px; text-align: center">
    Esta factura ha sido generada automáticamente por TiendaMVC y es válida sin firma.
</div>
