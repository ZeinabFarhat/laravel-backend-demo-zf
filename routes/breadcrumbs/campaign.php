<?php

use App\Models\User\User;

Breadcrumbs::resource( 'campaign', 'Campaigns' );

Breadcrumbs::for( 'campaign.archives', function ( $trail ) {
    $trail->parent( 'home' );
    $trail->push( 'Archived Campaigns', route( "campaign.archives" ) );
} );

Breadcrumbs::for( 'campaign.archive', function ( $trail, $model ) {
    $trail->parent( 'home' );
    $trail->push( 'Campaigns', route( "campaign.index" ) );
    $trail->push( 'Archive Campaign', route( "campaign.archive", $model ) );
} );

Breadcrumbs::for( 'campaign.unarchive', function ( $trail, $model ) {
    $trail->parent( 'home' );
    $trail->push( 'Campaigns', route( "campaign.index" ) );
    $trail->push( 'Unarchive Campaign', route( "campaign.unarchive", $model ) );
} );

Breadcrumbs::for( 'campaign_creatives.index', function ( $trail, $model ) {
    $trail->parent( 'home' );
    $trail->push( 'Campaign Creatives', route( "campaign_creatives.index", $model ) );
} );

Breadcrumbs::for( 'campaign_creatives.create', function ( $trail, $model) {
    $trail->parent( 'home' );
    $trail->push( 'Duplicate Creative', route( "campaign_creatives.create", [$model] ) );
} );
