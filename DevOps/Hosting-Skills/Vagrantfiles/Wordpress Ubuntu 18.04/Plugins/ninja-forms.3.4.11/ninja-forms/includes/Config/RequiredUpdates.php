<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_required_updates', array(

    'CacheCollateActions' => array(
        'class_name' => 'NF_Updates_CacheCollateActions',
        'requires' => array( 'CacheCollateForms' ),
        'nicename' => __( 'Update Actions Tables', 'ninja-forms' ),
    ),
    'CacheCollateForms' => array(
        'class_name' => 'NF_Updates_CacheCollateForms',
        'requires' => array(),
        'nicename' => __( 'Update Forms Tables', 'ninja-forms' ),
    ),
    'CacheCollateFields' => array(
        'class_name' => 'NF_Updates_CacheCollateFields',
        'requires' => array( 'CacheCollateActions' ),
        'nicename' => __( 'Update Fields Tables', 'ninja-forms' ),
    ),
    'CacheCollateObjects' => array(
        'class_name' => 'NF_Updates_CacheCollateObjects',
        'requires' => array( 'CacheCollateFields' ),
        'nicename' => __( 'Update Objects Tables', 'ninja-forms' ),
    ),
    'CacheCollateCleanup' => array(
        'class_name' => 'NF_Updates_CacheCollateCleanup',
        'requires' => array( 'CacheCollateObjects' ),
        'nicename' => __( 'Cleanup Orphan Records', 'ninja-forms' ),
    ),

));
