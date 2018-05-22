<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

$cakeDescription = 'TCOM test';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('jquery-ui.css') ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('home.css') ?>

    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('jquery-ui.min.js') ?>
    <?= $this->Html->script('bootstrap.js') ?>
    <?= $this->Html->script('bootbox.min.js') ?>
    <?= $this->Html->script('home.js') ?>
    <?= $this->Html->script('notify.js') ?>

</head>
<body class="home">
    <div class="container">

      <div class="row header">
        <div class="col-md-3">
            <input type="text" class="form-control filter"  name="author" id="author" placeholder="Author">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control filter"  name="year" id="year" placeholder="Year">
        </div>
        <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-addon"><i class="fas fa-binoculars"></i></div>
              <input type="text" class="form-control filter" name="title"  id="title" placeholder="Title">
            </div>
        </div>
        <div class="col-md-3 add">
            <button class="btn btn-primary"><i class="fas fa-plus"></i> NEW</button>
        </div>
    </div>
    
    <div id="books-data" class = "row">
        <i class="fa fa-spinner fa-spin"></i>
    </div>

</div>
</body>
</html>
