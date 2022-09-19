<?php

//Breadcrumbs::resource( 'banner', 'Banners' );

Breadcrumbs::for('banner.index', function ($trail) {
    $trail->parent( 'home' );
    $trail->push('Banners', route('banner.index'));
});


Breadcrumbs::for( 'edit_banner', function ( $trail, $model ) {
    $trail->parent( 'banner.index' );
    $trail->push( 'Edit Banner', route( "banner.index" ) );
} );

Breadcrumbs::for( 'banner.edit', function ( $trail, $model ) {
    $trail->parent( 'banner.index' );
    $trail->push( 'Edit Banner', route( "banner.index" ) );
} );


Breadcrumbs::for( 'preview_banner', function ( $trail, $model ) {
    $trail->parent( 'banner.index' );
    $trail->push( 'Preview Banner', route( "banner.index" ) );
} );

Breadcrumbs::for( 'create_banner', function ( $trail ) {
    $trail->parent( 'banner.index' );
    $trail->push( 'Create Banner', route( "banner.index" ) );
} );

