<?php


namespace MapUx\Command;


use Symfony\Component\Console\Style\SymfonyStyle;

class TwigBlocksAdder
{
    const CSS_BLOCK = '{% block cssmapux %}
        {{ encore_entry_link_tags(\'mapux\') }}
     {% endblock %}
    ';

    const SCRIPT_BLOCK = '{% block scriptsmapux %}
        {{ encore_entry_script_tags(\'mapux\') }}
    {% endblock %}
    ';

    const VALID_STEP_NUMBER = 2;

    private $file;
    private $content;

    public function __construct(string $file, SymfonyStyle $io)
    {
        $this->io = $io;
        $this->file = $file;
        if (is_file($this->file)) {
            $this->content = file_get_contents($file);
        } else {
            $this->io->error('file "base.html.twig" not found');
        }
    }

    private function hasHeadBlock()
    {
        return (count(explode('{% block cssmapux %}', $this->content)) === 2);
    }

    private function hasFooterBlock()
    {
        return (count(explode('{% block scriptsmapux %}', $this->content)) === 2);
    }

    public function addMapUxToHead(): self
    {
        if (!$this->hasHeadBlock()) {
            $this->blocks = explode('</head>', $this->content);
            if (2 === count($this->blocks)) {
                $this->content = $this->blocks[0] . self::CSS_BLOCK . '</head>' . $this->blocks[1];
                $this->io->comment('****** CSS block added into head section *******');
            }
        } else {
            $this->io->comment('block mapux CSS allready added');
        }
        return $this;
    }

    public function addMapUxToFooter(): self
    {
        if (!$this->hasFooterBlock()) {
            $this->blocks = explode('</footer>', $this->content);
            if (2 === count($this->blocks)) {
                $this->content = $this->blocks[0] . self::SCRIPT_BLOCK . '</footer>' . $this->blocks[1];
                $this->io->comment('****** scripts block added into footer section *******');
            }
        } else {
            $this->io->comment('block mapux Scripts allready added');
        }
        return $this;
    }

    public function save()
    {
        if ($this->hasHeadBlock() || $this->hasFooterBlock()) {
            file_put_contents($this->file, $this->content);
            $this->io->success('base.html.twig file updated');
            return true;
        }

        $this->io->error('Impossible to update base.html.twig');
        return false;
    }

}
