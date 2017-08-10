<?php
// Matcher that asserts that there is an element with an id="my_id".
$matcher = array('id' => 'my_id');

// Matcher that asserts that there is a "span" tag.
$matcher = array('tag' => 'span');

// Matcher that asserts that there is a "span" tag with the content
// "Hello World".
$matcher = array('tag' => 'span', 'content' => 'Hello World');

// Matcher that asserts that there is a "span" tag with content matching the
// regular expression pattern.
$matcher = array('tag' => 'span', 'content' => 'regexp:/Try P(HP|ython)/');

// Matcher that asserts that there is a "span" with an "list" class attribute.
$matcher = array(
  'tag'        => 'span',
  'attributes' => array('class' => 'list')
);

// Matcher that asserts that there is a "span" inside of a "div".
$matcher = array(
  'tag'    => 'span',
  'parent' => array('tag' => 'div')
);

// Matcher that asserts that there is a "span" somewhere inside a "table".
$matcher = array(
  'tag'      => 'span',
  'ancestor' => array('tag' => 'table')
);

// Matcher that asserts that there is a "span" with at least one "em" child.
$matcher = array(
  'tag'   => 'span',
  'child' => array('tag' => 'em')
);

// Matcher that asserts that there is a "span" containing a (possibly nested)
// "strong" tag.
$matcher = array(
  'tag'        => 'span',
  'descendant' => array('tag' => 'strong')
);

// Matcher that asserts that there is a "span" containing 5-10 "em" tags as
// immediate children.
$matcher = array(
  'tag'      => 'span',
  'children' => array(
    'less_than'    => 11,
    'greater_than' => 4,
    'only'         => array('tag' => 'em')
  )
);

// Matcher that asserts that there is a "div", with an "ul" ancestor and a "li"
// parent (with class="enum"), and containing a "span" descendant that contains
// an element with id="my_test" and the text "Hello World".
$matcher = array(
  'tag'        => 'div',
  'ancestor'   => array('tag' => 'ul'),
  'parent'     => array(
    'tag'        => 'li',
    'attributes' => array('class' => 'enum')
  ),
  'descendant' => array(
    'tag'   => 'span',
    'child' => array(
      'id'      => 'my_test',
      'content' => 'Hello World'
    )
  )
);

// Use assertTag() to apply a $matcher to a piece of $html.
$this->assertTag($matcher, $html);

// Use assertTag() to apply a $matcher to a piece of $xml.
$this->assertTag($matcher, $xml, '', FALSE);
?>
