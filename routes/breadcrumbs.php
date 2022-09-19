<?php

include_once 'breadcrumbs/resource.php';

Breadcrumbs::for( 'home', function ( $trail ) {
    $trail->push( 'Dashboard', url( '/' ) );
} );

Breadcrumbs::for( 'test', function ( $trail ) {
    $trail->push( 'Dashboard', url( '/' ) );
} );

Breadcrumbs::for( 'general_results_export', function ( $trail ) {
    $trail->push( 'Dashboard', url( '/' ) );
} );

Breadcrumbs::resource( 'advertiser', 'Advertisers' );
Breadcrumbs::resource( 'form-page', 'Form Pages' );
Breadcrumbs::for('user-profile.index', function ($trail) {
    $trail->push('Title Here', route('user-profile.index'));
});

Breadcrumbs::resource( 'spec', 'Specs' );

include_once 'breadcrumbs/user.php';
include_once 'breadcrumbs/campaign.php';
include_once 'breadcrumbs/creative.php';
include_once 'breadcrumbs/misc.php';
include_once 'breadcrumbs/videos.php';
include_once 'breadcrumbs/templates.php';
include_once 'breadcrumbs/logs.php';
include_once 'breadcrumbs/general.php';
include_once 'breadcrumbs/banner.php';
