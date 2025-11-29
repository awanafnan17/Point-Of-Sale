<?php
/**
 * @var array $allowed_modules
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div class="jumbotron text-center" style="background-color: #ecf0f1; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
    <h1 style="color: #2c3e50; font-weight: bold;">Welcome to Afnan's POS! 🚀</h1>
    <p style="font-size: 18px; color: #7f8c8d;">Your easy-to-use Point of Sale system. Click a module below to get started.</p>
    <div style="margin-top: 20px;">
        <a href="<?= base_url('sales') ?>" class="btn btn-success btn-lg" style="margin: 5px;">Start Selling <span class="glyphicon glyphicon-shopping-cart"></span></a>
        <a href="<?= base_url('items') ?>" class="btn btn-primary btn-lg" style="margin: 5px;">Add Items <span class="glyphicon glyphicon-plus"></span></a>
    </div>
</div>

<div id="home_module_list">
    <?php foreach($allowed_modules as $module) { ?>
        <div class="module_item" title="<?= lang("Module.$module->module_id" . '_desc') ?>">
            <a href="<?= base_url($module->module_id) ?>"><img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" style="border-width: 0; height: 64px; max-width: 64px;" alt="Menubar Image"></a>
            <a href="<?= base_url($module->module_id) ?>"><?= lang("Module.$module->module_id") ?></a>
        </div>
    <?php } ?>
</div>

<?= view('partial/footer') ?>
