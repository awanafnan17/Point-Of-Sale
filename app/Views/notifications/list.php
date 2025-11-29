<?= view('partial/header') ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title" style="color: white !important;"><span class="glyphicon glyphicon-bell"></span> Low Inventory Notifications</h3>
        </div>
        <div class="card-body">
            <?php if (empty($low_inventory)): ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok-circle"></span> All inventory levels are healthy!
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-warning-sign"></span> The following items are low in stock.
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Item Number</th>
                            <th>Stock Location</th>
                            <th>Current Quantity</th>
                            <th>Reorder Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($low_inventory as $item): ?>
                            <tr>
                                <td><?= esc($item['name']) ?></td>
                                <td><?= esc($item['item_number']) ?></td>
                                <td><?= esc($item['location_name']) ?></td>
                                <td class="text-danger"><strong><?= esc($item['quantity']) ?></strong></td>
                                <td><?= esc($item['reorder_level']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= view('partial/footer') ?>
