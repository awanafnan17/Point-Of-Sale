<?php
/**
 * @var object $user_info
 * @var array $allowed_modules
 * @var CodeIgniter\HTTP\IncomingRequest $request
 * @var array $config
 */

use Config\Services;

$request = Services::request();
?>

<!doctype html>
<html lang="<?= $request->getLocale() ?>">

<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . ' | ' . lang('Common.powered_by') . ' ' . esc(config('App')->application_version) ?></title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <?php
    // Theme Loading
    $theme = (empty($config['theme']) ? 'flatly' : $config['theme']);
    echo '<link rel="stylesheet" href="' . base_url('resources/bootswatch/' . $theme . '/bootstrap.min.css') . '">';

    // Dynamic CSS Loading
    $prod_css = glob(FCPATH . 'resources/opensourcepos-*.min.css');
    if (!empty($prod_css)) {
        echo '<link rel="stylesheet" href="' . base_url('resources/' . basename($prod_css[0])) . '">';
    } else {
        $debug_css = glob(FCPATH . 'resources/css/*.css');
        if (!empty($debug_css)) {
            $priority_css = ['bootstrap', 'jquery-ui', 'ospos'];
            $loaded_css = [];
            foreach ($priority_css as $p) {
                foreach ($debug_css as $file) {
                    $basename = basename($file);
                    if (strpos($basename, $p) === 0 && !in_array($basename, $loaded_css)) {
                        echo '<link rel="stylesheet" href="' . base_url('resources/css/' . $basename) . '">';
                        $loaded_css[] = $basename;
                    }
                }
            }
            foreach ($debug_css as $file) {
                $basename = basename($file);
                if (!in_array($basename, $loaded_css)) {
                    echo '<link rel="stylesheet" href="' . base_url('resources/css/' . $basename) . '">';
                }
            }
        }
    }

    // Dynamic JS Loading
    $prod_js = glob(FCPATH . 'resources/opensourcepos-*.min.js');
    $jquery_prod = glob(FCPATH . 'resources/jquery-*.min.js');
    
    if (!empty($prod_js) && !empty($jquery_prod)) {
        echo '<script src="' . base_url('resources/' . basename($jquery_prod[0])) . '"></script>';
        echo '<script src="' . base_url('resources/' . basename($prod_js[0])) . '"></script>';
    } else {
        $debug_js = glob(FCPATH . 'resources/js/*.js');
        if (!empty($debug_js)) {
            $priority_js = ['jquery-', 'bootstrap-', 'jquery-ui-', 'moment-']; // Added moment- to priority
            $loaded_js = [];
            foreach ($debug_js as $file) {
                $basename = basename($file);
                if (strpos($basename, 'jquery-') === 0 && strpos($basename, 'jquery-ui') === false && strpos($basename, 'jquery-form') === false && strpos($basename, 'jquery-validation') === false) {
                     echo '<script src="' . base_url('resources/js/' . $basename) . '"></script>';
                     $loaded_js[] = $basename;
                     break;
                }
            }
            foreach ($priority_js as $p) {
                foreach ($debug_js as $file) {
                    $basename = basename($file);
                    if (strpos($basename, $p) === 0 && !in_array($basename, $loaded_js)) {
                        echo '<script src="' . base_url('resources/js/' . $basename) . '"></script>';
                        $loaded_js[] = $basename;
                    }
                }
            }
            foreach ($debug_js as $file) {
                $basename = basename($file);
                if (!in_array($basename, $loaded_js)) {
                    echo '<script src="' . base_url('resources/js/' . $basename) . '"></script>';
                }
            }
        }
    }
    ?>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

    <style>
        html {
            overflow: auto;
        }
    </style>
    <!-- Custom UI for Simplified Experience -->
    <link rel="stylesheet" href="<?= base_url('css/custom_ui.css') ?>">
</head>

<body>
    <div class="wrapper">
        <div class="topbar">
            <div class="container">
                <div class="navbar-left">
                    <div id="liveclock"><?= date($config['dateformat'] . ' ' . $config['timeformat']) ?></div>
                </div>

                <div class="navbar-right" style="margin: 0;">
                    <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                    <span>&nbsp;|&nbsp;</span>
                    <?= anchor('home/logout', lang('Login.logout')) ?>
                </div>

                <div class="navbar-center" style="text-align: center;">
                    <strong><?= esc($config['company']) ?></strong>
                </div>
            </div>
        </div>

        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand hidden-sm" href="<?= site_url() ?>">
                        <img src="<?= base_url('images/logo.png') ?>" alt="Afnan's POS" style="height: 40px; margin-top: -10px;">
                    </a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?= base_url('manual.html') ?>" target="_blank" class="btn btn-info btn-lg" style="color: white !important; margin-top: 5px; padding: 10px 20px; font-weight: bold;">
                            <span class="glyphicon glyphicon-question-sign"></span> User Manual
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('notifications') ?>" class="btn btn-warning btn-lg" style="color: white !important; margin-top: 5px; padding: 10px 20px; font-weight: bold; margin-left: 10px;">
                            <span class="glyphicon glyphicon-bell"></span> Notifications
                        </a>
                    </li>
                        <?php foreach ($allowed_modules as $module): ?>
                            <li class="<?= $module->module_id == $request->getUri()->getSegment(1) ? 'active' : '' ?>">
                                <a href="<?= base_url($module->module_id) ?>" title="<?= lang("Module.$module->module_id") ?>" class="menu-icon">
                                    <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" style="border: none;" alt="Module Icon"><br>
                                    <?= lang('Module.' . $module->module_id) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
