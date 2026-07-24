<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
// Asset Packagist installs to vendor/bower-asset (and vendor/npm-asset).
// Keep vendor/bower -> bower-asset (and vendor/npm -> npm-asset) symlinks in sync;
// Application::setVendorPath() defaults @bower/@npm to vendor/bower and vendor/npm.
Yii::setAlias('@bower', dirname(__DIR__) . '/vendor/bower-asset');
Yii::setAlias('@npm', dirname(__DIR__) . '/vendor/npm-asset');
