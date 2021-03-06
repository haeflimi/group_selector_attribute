<?php
namespace Concrete\Package\GroupSelectorAttribute;

use Package,
    Concrete\Core\Backup\ContentImporter,
    Core,
    Config,
    Events;

class Controller extends Package
{
    protected $pkgHandle = 'group_selector_attribute';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.9';

    public function getPackageName()
    {
        return t('Group Selector Attribute');
    }

    public function getPackageDescription()
    {
        return t('Concrete5 Attribute that allows the selection of single and/or multiple user groups.');
    }

    public function on_start()
    {

    }

    public function install()
    {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function upgrade()
    {
        parent::upgrade();
    }
}