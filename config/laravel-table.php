<?php

return [

    'classes' => [
        'container' => ['table-responsive'],
        'table'     => ['table-striped', 'table-hover'],
        'tr'        => [],
        'th'        => ['align-middle'],
        'td'        => ['align-middle'],
        'results'   => ['table-dark', 'font-weight-bold'],
        'disabled'  => ['table-danger', 'disabled'],
    ],

    'icon' => [
        'rowsNumber' => '<i class="fa fa-list"></i>',
        'sort'       => '<i class="fa fa-sort fa-fw"></i>',
        'sortAsc'    => '<i class="fa fa-sort-up fa-fw"></i>',
        'sortDesc'   => '<i class="fa fa-sort-down fa-fw"></i>',
        'search'     => '<i class="fa fa-search"></i>',
        'validate'   => '<i class="fa fa-check"></i>',
        'cancel'     => '<i class="fa fa-times"></i>',
        'create'     => '<i class="fa fa-plus-circle fa-fw "></i>',
        'edit'       => '<i class="fa fa-edit fa-fw"></i>',
        'destroy'    => '<i class="fa fa-trash fa-fw"></i>',
    ],

    'value' => [
        'rowsNumber'                    => 20,
        'rowsNumberSelectionActivation' => true,
    ],

    'template' => [
        'table'   => 'bootstrap.table',
        'thead'   => 'bootstrap.thead',
        'tbody'   => 'bootstrap.tbody',
        'results' => 'bootstrap.results',
        'tfoot'   => 'bootstrap.tfoot',
    ],

];
