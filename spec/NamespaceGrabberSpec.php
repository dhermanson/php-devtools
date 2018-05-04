<?php

namespace spec\dhermanson\DevTools;

use dhermanson\DevTools\NamespaceGrabber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PhpParser\ParserFactory;

class NamespaceGrabberSpec extends ObjectBehavior
{

  function it_should_extract_namespace_for_a_class() {
    $code = <<<'EOL'
<?php

namespace App\Something\Awesome;

class Person {

}
EOL
    ;
    $line = 5;

    $this->getNamespacedName($code, $line)->shouldEqual('App\Something\Awesome\Person');
  }

  function it_should_extract_namespace_for_a_function() {
    $code = <<<'EOL'
<?php

namespace App\Something\Even\Better;


function yeahDude($one, $two, $three) {

}

EOL
    ;
    $line = 6;

    $this->getNamespacedName($code, $line)->shouldEqual('App\Something\Even\Better\yeahDude');
  }
}
