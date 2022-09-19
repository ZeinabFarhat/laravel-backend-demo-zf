<?php

Breadcrumbs::macro( 'resource', function ( $name, $title ) {
    // Home > Blog
    Breadcrumbs::for( "$name.index", function ( $trail ) use ( $name, $title ) {
        $trail->parent( 'home' );
        $trail->push( Str::plural( $title ), route( "$name.index", Route::current()->parameters() ) );
    } );

    // Home > Blog > New
    Breadcrumbs::for( "$name.create", function ( $trail ) use ( $name ) {
        $trail->parent( "$name.index" );
        $trail->push( 'New', route( "$name.create" ) );
    } );

    // Home > Blog > Post 123
    Breadcrumbs::for( "$name.show", function ( $trail, $model ) use ( $name ) {
        $trail->parent( "$name.index" );
        if ( isset( $model->name ) ) {
            $trail->push( $model->name, route( "$name.show", $model ) );
        } else {
            // TODO: Handle stuff here! check for cases and then unify it ( :) sinclair smile )
        }
    } );

    // Home > Blog > Post 123 > Edit
    Breadcrumbs::for( "$name.edit", function ( $trail, $model ) use ( $name ) {
        $trail->parent( "$name.show", $model );
        $trail->push( 'Edit', route( "$name.edit", Route::current()->parameters() ) );
    } );
} );
