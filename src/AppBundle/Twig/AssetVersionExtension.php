<?php

namespace AppBundle\Twig;

class AssetVersionExtension extends \Twig_Extension
{
    private $appDir;

    public function __construct($appDir)
    {
        $this->appDir = $appDir;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('asset_version', array($this, 'getAssetVersion')),
        );
    }

    public function getAssetVersion($filename)
    {
        $trimedFile = rtrim($filename, '/');
        $explodedFilePath = explode('/', $trimedFile);
        $file = array_pop($explodedFilePath);
        $file_path = implode('/', $explodedFilePath).'/';

        $manifestPath = $this->appDir.'/Resources/assets/rev-manifest.json';
        if (!file_exists($manifestPath)) {
            throw new \Exception(sprintf('Cannot find manifest file: "%s"', $manifestPath));
        }

        $paths = json_decode(file_get_contents($manifestPath), true);
        if (!isset($paths[$file])) {
            throw new \Exception(sprintf('There is no file "%s" in the version manifest!', $filename));
        }

        return $file_path.$paths[$file];
    }

    public function getName()
    {
        return 'asset_version';
    }
}
