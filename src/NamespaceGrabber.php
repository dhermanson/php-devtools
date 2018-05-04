<?php

namespace dhermanson\DevTools;

use PhpParser\{Node, NodeFinder, Parser, NodeTraverser, ParserFactory};
use PhpParser\NodeVisitor\{NameResolver};
use PhpParser\Node\Stmt;

class NamespaceGrabber {

  public function getNamespacedName($code, $line) {
    $ast = $this->parseAst($code);
    $ast = $this->resolveNames($ast);
    $node = $this->findNode($ast, $line);
    $namespace = $this->extractNamespacedNameFromNode($node);
    return $namespace;
  }

  private function parseAst($code) {
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    return $parser->parse($code);
  }

  private function resolveNames($ast) {
    $nameResolver = new NameResolver();
    $nodeTraverser = new NodeTraverser();
    $nodeTraverser->addVisitor($nameResolver);

    return $nodeTraverser->traverse($ast);
  }

  private function findNode($ast, $line) : Node {
    return (new NodeFinder())->findFirst($ast, function(Node $node) use ($line) {
      return $node->getLine() == $line;
    });
  }

  private function extractNamespacedNameFromNode(Node $node) : string {
    return implode("\\", $node->namespacedName->parts);
  }

}
