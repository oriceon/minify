<?php

namespace spec\Oriceon\Minify\Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Prophet;
use org\bovigo\vfs\vfsStream;

class JavaScriptSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Oriceon\Minify\Providers\JavaScript');
    }

    function it_adds_one_file()
    {
        vfsStream::setup('js', null, [
            '1.js' => 'a',
        ]);

        $this->add(VfsStream::url('js'));
        $this->shouldHaveCount(1);
    }

    function it_adds_multiple_files()
    {
        vfsStream::setup('root', null, [
            '1.js' => 'a',
            '2.js' => 'b',
        ]);

        $this->add([
            VfsStream::url('root/1.js'),
            VfsStream::url('root/2.js')
        ]);

        $this->shouldHaveCount(2);
    }

    function it_adds_custom_attributes()
    {
        $this->tag('file', ['foobar' => 'baz', 'defer' => true])
            ->shouldReturn('<script src="file" foobar="baz" defer></script>' . PHP_EOL);
    }

    function it_adds_without_custom_attributes()
    {
      $this->tag('file', [])
            ->shouldReturn('<script src="file"></script>' . PHP_EOL);
    }

    function it_throws_exception_when_file_not_exists()
    {
        $this->shouldThrow('Oriceon\Minify\Exceptions\FileNotExistException')
            ->duringAdd('foobar');
    }

    function it_should_throw_exception_when_build_path_not_exist()
    {
      $prophet = new Prophet;
      $file = $prophet->prophesize('Illuminate\Filesystem\Filesystem');
      $file->makeDirectory('dir_bar', 0775, true)->willReturn(false);

      $this->beConstructedWith(null, null, $file);
      $this->shouldThrow('Oriceon\Minify\Exceptions\DirNotExistException')
            ->duringMake('dir_bar');
    }

    function it_should_throw_exception_when_build_path_not_writable()
    {
        vfsStream::setup('js', 0555, []);

        $this->shouldThrow('Oriceon\Minify\Exceptions\DirNotWritableException')
            ->duringMake(vfsStream::url('js'));
    }

    function it_minifies_multiple_files()
    {
        vfsStream::setup('root', null, [
            'output' => [],
            '1.js'   => 'a',
            '2.js'   => 'b',
        ]);

        $this->add(vfsStream::url('root/1.js'));
        $this->add(vfsStream::url('root/2.js'));

        $this->make(vfsStream::url('root/output'));

        $this->getAppended()->shouldBe("a\nb\n");

        $output = md5('vfs://root/1.js-vfs://root/2.js');
        $filemtime = filemtime(vfsStream::url('root/1.js')) + filemtime(vfsStream::url('root/2.js'));
        $extension = '.js';

        $this->getFilename()->shouldBe($output . $filemtime . $extension);
    }
}
