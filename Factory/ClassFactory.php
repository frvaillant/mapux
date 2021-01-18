<?php

namespace MapUx\Factory;


class ClassFactory
{

    const EXTENSION = 'php';

    const START = '<?php
    ';

    const END = '
}';

    private $nameSpace;

    private $name;

    private $constants;


    public function __construct(string $nameSpace, string $name, array $constants)
    {
        $this->nameSpace = $nameSpace;

        $this->name = $name;

        $this->constants = $constants;

        $folder = $this->getAbsoluteFolderPath();
        $this->create($folder, $this->makeFileName());
    }

    private function getAbsoluteFolderPath()
    {
        list($unused, $folder) = explode('MapUx\\', $this->nameSpace);
        return __DIR__ . '/../' . str_replace('\\', '/', $folder);
    }

    private function makeNameSpace()
    {
        return '
namespace ' . $this->nameSpace . ';
        ';
    }

    private function makeClassName()
    {
        return '
class ' . $this->name . ' {

';
    }

    private function makeFileName()
    {
        return $this->name . '.' . self::EXTENSION;
    }

    public function createConstants()
    {
        $consts = '';

        foreach ($this->constants as $name => $value) {

            if (is_string($value)) {
                $consts .= '
    const ' . strtoupper($name) . ' = \'' . $value . '\';
        ';
            }

            if (is_float($value) || is_integer($value) || is_bool($value)) {
                $consts .= '
    const ' . strtoupper($name) . ' = ' . $value . ';
        ';
            }

            if (is_array($value)) {
                $consts .= '
    const ' . strtoupper($name) . ' = [
        ';
                foreach ($value as $key => $val) {
                    $consts .= '\'' . $key . '\' => \'' . $val . '\',
        ';
                }
                $consts .= '
    ];
            ';
            }
        }

            return $consts;
        }


    private function makeContent()
    {
        return 
            self::START . 
                $this->makeNameSpace() . 
                $this->makeClassName() . 
                $this->createConstants() . 
            self::END;
    }

    private function create($dir, $fileName)
    {
        file_put_contents($dir . '/' . $fileName, $this->makeContent());
    }



}
