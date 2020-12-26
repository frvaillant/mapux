<?php


namespace MapUx\Command;


use Symfony\Component\Console\Style\SymfonyStyle;

class EntryPointAdder
{
    const ENTRY_POINT = 'Encore
        .addEntry(\'mapux\', \'./vendor/frvaillant/mapux/Resources/assets/mapux.js\')
        .copyFiles({
        from: \'./node_modules/leaflet/dist/images\',
        to: \'images/[path][name].[ext]\',
        })
    ';
    
    const SEPARATOR   = 'module.export';

    private $file;
    private $content;

    public function __construct(string $file, SymfonyStyle $io)
    {
        $this->io = $io;
        $this->file = $file;
        if (is_file($file)) {
            $this->content = file_get_contents($file);
        } else {
            $this->io->error('file Webpack.config.js not found');
        }
       
    }

    private function separateWebpackFile()
    {
        $this->blocks = explode(self::SEPARATOR, $this->content);
    }

    private function addEntryPoint()
    {
        $this->blocks[0] .= '
        ' . self::ENTRY_POINT;
    }

    private function makeFile()
    {
        return implode(self::SEPARATOR, $this->blocks);
    }
    
    private function isWebpackEncoreFile()
    {
        return count(explode('var Encore = ', $this->content)) > 1;
    }
    
    private function hasAllreadyEntryPoint()
    {
        return count(explode('.addEntry(\'mapux\',', $this->content)) > 1;
    }
    
    private function hasModuleExport()
    {
        return count(explode(self::SEPARATOR, $this->content)) > 1;
    }

    public function generateNewWebpackFile()
    {
        if ($this->isWebpackEncoreFile() && !$this->hasAllreadyEntryPoint() && $this->hasModuleExport()) {
            $this->separateWebpackFile();
            $this->addEntryPoint();
            $this->saveFile($this->makeFile());
            $this->io->success('Entry point added');
            return true;
        }
        $this->io->error('Impossible to update webpack.config.js. Please refer to mapux documentation');
        return false;
    }

    private function saveFile($content)
    {
        file_put_contents($this->file, $content);
    }



}
